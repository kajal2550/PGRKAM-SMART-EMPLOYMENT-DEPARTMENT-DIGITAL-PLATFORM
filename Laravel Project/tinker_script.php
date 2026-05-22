echo 'Notifications: ' . \App\Models\Notification::count() . PHP_EOL;
echo 'Applications: ';
$apps = \Illuminate\Support\Facades\DB::table('job_applications')->get();
foreach($apps as $a) { echo $a->user_id . ':' . $a->job_id . '  '; }
echo PHP_EOL;
echo 'Users: ';
$users = \App\Models\User::all(['id','email']);
foreach($users as $u) { echo $u->id . ':' . $u->email . '  '; }
