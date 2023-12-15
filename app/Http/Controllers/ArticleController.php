<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'verified'])->except(['index', 'show']);
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('article.index');
    }

    public function listApi()
    {
        return response()->json(Article::where('id', '>', 0)->orderByDesc('id')->get()->map(function (Article $article) {
            if (isset($article->picture) && Storage::exists($article->picture)) {
                $article->picture = config('app.url') . Storage::url($article->picture);
            }
            $article->publish = $article->publish == 1 ? true : false;
            return $article;
        })->toArray());
    }

    public function itemApi(Article $article)
    {
        $article->publish = $article->publish == 1 ? true : false;
        if (isset($article->picture) && Storage::exists($article->picture)) {
            $article->picture = config('app.url') . Storage::url($article->picture);
        }
        return response()->json($article->toArray());
    }

    public function storeApi(Request $request)
    {
        // log
        // file_put_contents(
        // $_SERVER["DOCUMENT_ROOT"] . '/debug.log',
        // date('m-d h:i') . " storeApi request all: " . print_r($request->all(), true) . "\n",
        // FILE_APPEND
        // );

        $validator = Validator::make($request->all(), $rules = [
            'publish' => 'nullable',
            'sort' => 'nullable|integer|max_digits:3',
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:5000',
            // 'picture' => 'image|dimensions:max_width=2048,max_height=1600|max:1024'
        ], $messages = [
                'sort.integer' => 'The :attribute field must consist only integer.',
                'picture.image' => 'The :attribute field must be only image.',
                'picture.dimensions' => 'The :attribute field must be max width is 1024, height 768.'
            ]);

        $result = ['id' => 0];

        if ($validator->fails()) {
            $result['errors'] = $validator->errors()->toArray();

            // log
            // file_put_contents(
            // $_SERVER["DOCUMENT_ROOT"] . '/debug.log',
            // date('m-d h:i') . " errors: " . print_r($result, true) . "\n",
            // FILE_APPEND
            // );

            return response()->json($result);
        }

        $validated = $validator->validated();

        // correct sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 0) {
                $validated['sort'] = 1;
            }
        } else {
            $validated['sort'] = 1;
        }

        // correct boolean
        if ($request->has('publish')) {
            $validated['publish'] = $request->input('publish') == 'true' ? 1 : 0;
        } else {
            $validated['publish'] = 0;
        }

        // correct picture
        if ($request->has('picture') && !empty($request->file('picture'))) {
            $validated['picture'] = $request->file('picture')->storePublicly('public/articles');
        }

        // log
        // file_put_contents(
        // $_SERVER["DOCUMENT_ROOT"] . '/debug.log',
        // date('m-d h:i') . " storeApi validated: " . print_r($validated, true) . "\n",
        // FILE_APPEND
        // );

        $create = true;
        if ($request->post()['id'] > 0) {
            $article = Article::where('id', $request->post()['id'])->get();
            if ($article->count() == 1) {
                $create = false;
            }
        }

        if ($create) {
            $article = Article::create($validated);
            $result['id'] = $article['id'];
        } else {
            $article->first()->update($validated);
            $result['id'] = $request->post()['id'];
        }

        // log
        // file_put_contents(
        // $_SERVER["DOCUMENT_ROOT"] . '/debug.log',
        // date('m-d h:i') . " result: " . print_r($result, true) . "\n",
        // FILE_APPEND
        // );

        return response()->json($result);
    }

    public function destroyApi(Article $article)
    {
        // log
        // file_put_contents(
        // $_SERVER["DOCUMENT_ROOT"] . '/debug.log',
        // date('m-d h:i') . " destroyApi article: " . print_r($article, true) . "\n",
        // FILE_APPEND
        // );

        $result = ['code' => 0, 'message' => '', 'context' => $article->id];

        try {
            $article->delete();
            if (isset($article->picture) && Storage::exists($article->picture)) {
                Storage::delete($article->picture);
            }
            $result['code'] = 1;
        } catch (Exception $e) {
            $result['code'] = 2;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
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

        return redirect(route('article.index'));
    }

    /*public function testStoreApi(Request $request)
    {
        $result = [
            'errors' => [
                // 'sort' => ['f' => 'a', 'z' => 'b'],
                'soft' => ['a', 's'],
                'topo' => []
            ],
            'withoutkeysarray' => ['a', 's'],
            'id' => $request->input('id')
        ];
        file_put_contents(
            $_SERVER["DOCUMENT_ROOT"] . '/debug.log',
            date('m-d h:i:s A') . " result: " . print_r($result, true) . "\n",
            FILE_APPEND
        );
        return response()->json($result);
    }*/

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        /* remove to api
         if (!$article->publish) {
         return redirect(route('article.index'));
         }
         if (isset($article->picture)) {
            // $article->picture = config('app.url') . Storage::url($article->picture);
         }
         return response()->json($article->toArray());
        */
        return view('article.show', ['article' => $article]);
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

        return redirect(route('article.index'));
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