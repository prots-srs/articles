<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Article::where('publish', true)->orderBy('sort')->get()->map(function (Article $article) {
            if (isset($article->picture)) {
                $article->picture = env('APP_URL') . Storage::url($article->picture);
            }
            return $article;
        })->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->transformInputs($request, $validated);
        if ($request->has('picture')) {
            $validated['picture'] = $request->file('picture')->storePublicly('public/articles');
        }

        Article::create($validated);

        return redirect(route('article.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        if (!$article->publish) {
            return redirect(route('article.index'));
        }
        if (isset($article->picture)) {
            $article->picture = env('APP_URL') . Storage::url($article->picture);
        }

        return response()->json($article->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validated = $request->validated();
        $this->transformInputs($request, $validated);

        if ($request->has('pictureclear') && Storage::exists($article->picture)) {
            Storage::delete($article->picture);
        }

        if ($request->has('picture')) {
            $validated['picture'] = $request->file('picture')->storePublicly('public/articles');
        }
        $article->update($validated);

        return redirect(route('article.edit', ['article' => $article]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (isset($article->picture) && Storage::exists($article->picture)) {
            Storage::delete($article->picture);
        }
        $article->delete();

        return redirect(route('article.create'));
    }

    private function transformInputs($request, &$validated)
    {
        if (empty($validated['sort'])) {
            $validated['sort'] = 10;
        }
        // $validated['publish'] = isset($validated['publish']) ? true : false;
        $validated['publish'] = $request->has('publish') ? true : false;
    }
}