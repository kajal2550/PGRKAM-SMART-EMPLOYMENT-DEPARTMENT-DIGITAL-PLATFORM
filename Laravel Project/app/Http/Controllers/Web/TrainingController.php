<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::where('is_active', true);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%$s%")
                  ->orWhere('provider', 'like', "%$s%")
                  ->orWhere('category', 'like', "%$s%");
            });
        }
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        $trainings = $query->orderBy('title')->get();

        $enrolled = [];
        if (Auth::check()) {
            $enrolled = DB::table('training_user')->where('user_id', Auth::id())->pluck('training_id')->toArray();
        }

        $categories = ['All', 'IT', 'Electrical', 'Marketing', 'Finance', 'Handcraft', 'Communication'];

        return view('training.index', compact('trainings', 'enrolled', 'categories'));
    }

    public function showEnroll(Request $request, $id)
    {
        $training   = Training::findOrFail($id);
        $isEnrolled = Auth::check()
            ? DB::table('training_user')->where('user_id', Auth::id())->where('training_id', $id)->exists()
            : false;
        $seatsLeft = max(0, $training->total_seats - $training->enrolled_count);
        return view('training.enroll', compact('training', 'isEnrolled', 'seatsLeft'));
    }

    public function enroll(Request $request, $id)
    {
        $training = Training::findOrFail($id);

        $request->validate([
            'phone'            => 'required|string|max:15',
            'qualification'    => 'required|string',
            'preferred_timing' => 'required|in:Morning,Afternoon,Evening,Weekend',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $exists = DB::table('training_user')->where('user_id', Auth::id())->where('training_id', $id)->exists();
        if ($exists) {
            return back()->with('error', 'You are already enrolled in this program.');
        }

        if ($training->enrolled_count >= $training->total_seats) {
            return back()->with('error', 'Sorry, all seats are filled for this program.');
        }

        DB::table('training_user')->insert([
            'user_id'          => Auth::id(),
            'training_id'      => $id,
            'phone'            => $request->phone,
            'qualification'    => $request->qualification,
            'preferred_timing' => $request->preferred_timing,
            'notes'            => $request->notes,
            'status'           => 'enrolled',
            'enrolled_at'      => now(),
        ]);

        $training->increment('enrolled_count');

        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Training Enrollment Confirmed',
            'message' => "You have successfully enrolled in \"{$training->title}\". Our team will contact you with further details on your registered mobile number.",
            'type'    => 'training',
            'link'    => '/enrollments',
            'is_read' => false,
        ]);

        return back()->with('success', "Enrolled in '{$training->title}' successfully! You will receive details on your mobile.");
    }
}
