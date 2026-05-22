<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * ChatGuideController – Smart Guidance Engine
 *
 * Receives a plain-language message from the user and returns
 * matched module suggestions based on keyword analysis.
 */
class ChatGuideController extends Controller
{
    /**
     * Keyword → module mapping.
     */
    private const MODULES = [
        [
            'keywords'    => ['job', 'jobs', 'employment', 'work', 'vacancy', 'sarkari', 'govt', 'government', 'naukri'],
            'module'      => 'Government Jobs',
            'path'        => '/jobs',
            'icon'        => '🏛️',
            'color'       => 'blue',
            'description' => 'Browse government and public sector job openings.',
        ],
        [
            'keywords'    => ['private', 'company', 'corporate', 'mnc', 'startup', 'industry', 'sector'],
            'module'      => 'Private Jobs',
            'path'        => '/jobs?type=private',
            'icon'        => '🏢',
            'color'       => 'indigo',
            'description' => 'Explore private sector and corporate job opportunities.',
        ],
        [
            'keywords'    => ['skill', 'training', 'course', 'learn', 'certificate', 'trade', 'vocational', 'itc', 'iti'],
            'module'      => 'Skill Training',
            'path'        => '/training',
            'icon'        => '🎓',
            'color'       => 'green',
            'description' => 'Enroll in government-sponsored skill development programs.',
        ],
        [
            'keywords'    => ['resume', 'cv', 'biodata', 'profile', 'portfolio'],
            'module'      => 'Resume Builder',
            'path'        => '/resume',
            'icon'        => '📄',
            'color'       => 'orange',
            'description' => 'Create and manage your professional resume.',
        ],
        [
            'keywords'    => ['career', 'counsel', 'counselling', 'guide', 'advice', 'mentor', 'direction'],
            'module'      => 'Career Counselling',
            'path'        => '/counselling',
            'icon'        => '💬',
            'color'       => 'purple',
            'description' => 'Get personalised career guidance from certified experts.',
        ],
    ];

    /**
     * POST /api/chat-guide
     *
     * Body: { "message": "I need a government job" }
     */
    public function handle(Request $request): JsonResponse
    {
        $request->validate(['message' => ['required', 'string', 'max:500']]);

        $message     = strtolower($request->message);
        $suggestions = [];

        foreach (self::MODULES as $mod) {
            foreach ($mod['keywords'] as $kw) {
                if (str_contains($message, $kw)) {
                    // Avoid duplicates
                    if (! collect($suggestions)->contains('path', $mod['path'])) {
                        $suggestions[] = [
                            'module'      => $mod['module'],
                            'path'        => $mod['path'],
                            'icon'        => $mod['icon'],
                            'color'       => $mod['color'],
                            'description' => $mod['description'],
                        ];
                    }
                    break;
                }
            }
        }

        $reply = count($suggestions) > 0
            ? 'Based on your query, here are the relevant services:'
            : "I couldn't find a direct match. Try keywords like \"job\", \"training\", \"resume\", or \"career counselling\".";

        return response()->json([
            'reply'       => $reply,
            'suggestions' => $suggestions,
        ]);
    }
}
