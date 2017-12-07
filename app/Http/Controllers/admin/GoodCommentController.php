<?php

namespace App\Http\Controllers\admin;

use App\Models\Good;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\GoodComment;
use Carbon\Carbon;

class GoodCommentController extends Controller
{
    public function __construct() {
        $this->authorize('index', new GoodComment());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFormFilter($request->input());

        $comments = GoodComment::orderBy('id', 'desc');
        if (!empty($filters) && !empty($filters['good_id'])) {
            $comments->where('good_id', $filters['good_id']);
            $filters['good'] = Good::where('id', $filters['good_id'])->first();
        }
        if (!empty($filters) && !empty($filters['date_from'])) {
            $comments->where('date', '>=', (new Carbon($filters['date_from']))->format('Y.m.d'));
        }
        if (!empty($filters) && !empty($filters['date_to'])) {
            $comments->where('date', '<=', (new Carbon($filters['date_to']))->format('Y.m.d'));
        }
        if (!empty($filters) && isset($filters['status']) && $filters['status']!='') {
            $comments->where('status', $filters['status']);
        }
        $comments = $comments->paginate($filters['perpage'], null, 'page', !empty($filters['page']) ? $filters['page'] : null);

        return view('admin.comments.index', ['comments' => $comments, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $good = [];
        if(old() && old('good_id')) {
            $good = Good::where('id', old('good_id'))->first();
        }
        return view('admin.comments.create', ['good' => $good]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\GoodCommentRequest $request)
    {
        $data = $request->all();
        $data['date'] = (new Carbon($data['date']))->format('Y.m.d');
        GoodComment::create($data);

        return redirect()->route('admin.comments.index')->withMessage('Комментарий добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = GoodComment::findOrFail($id);
        if(old() && old('good_id')) {
            $good = Good::where('id', old('good_id'))->first();
        } elseif($comment->good_id) {
            $good = Good::where('id', $comment->good_id)->first();
        }
        return view('admin.comments.edit', ['comment' => $comment,'good' => (!empty($good) ? $good : [])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\admin\GoodCommentRequest $request, $id)
    {
        $comment = GoodComment::findOrFail($id);
        $data = $request->all();
        $data['date'] = (new Carbon($data['date']))->format('Y.m.d');
        $comment->update($data);
        return redirect()->route('admin.comments.index')->withMessage('Комментарий изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GoodComment::destroy($id);
        return redirect()->route('admin.comments.index')->withMessage('Комментарий удален');
    }

}
