<?php

namespace App\Http\Controllers;

use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;

enum AccessOperation
{
    case UPDATE;
    case DELETE;
}

enum ThemeOperation
{
    case ARTICLE;
}

class ContentAccessApiController extends Controller
{
    private const ADMIN_EMAIL = 'prots.srs@gmail.com';
    private ThemeOperation $theme;
    private AccessOperation $operation;

    private bool $canAccess = false;
    public function __invoke(Request $request)
    {
        $this->canAccess = false;

        $this->defineRequest($request);
        $this->defineCan();

        return response()->json(
            [
                'can' => $this->canAccess,
                // 'user_email' => auth()->user()->email
            ]
        );
    }

    private function defineCan()
    {
        switch ($this->theme) {
            case ThemeOperation::ARTICLE:
                switch ($this->operation) {
                    case AccessOperation::UPDATE:
                        if (auth()->user()->email == self::ADMIN_EMAIL) {
                            $this->canAccess = true;
                        }
                        break;
                    case AccessOperation::DELETE:
                        if (auth()->user()->email == self::ADMIN_EMAIL) {
                            $this->canAccess = true;
                        }
                        break;
                }
                break;
        }
    }

    private function defineRequest(Request $request)
    {
        switch ($request->theme) {
            case 'article':
                $this->theme = ThemeOperation::ARTICLE;
                break;
        }

        switch ($request->operation) {
            case 'update':
                $this->operation = AccessOperation::UPDATE;
                break;
            case 'delete':
                $this->operation = AccessOperation::DELETE;
                break;
        }

    }
}