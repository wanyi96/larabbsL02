<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{

		$topics = $topic->withOrder($request->order)
                        ->with('user','category')  //使用预加载,避免N+1次查询
                        ->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

		return redirect()->to($topic->link())->with('message', '帖子创建成功!');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', '更新成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化返回数据，默认是失败的
        $data = [
            'success'   =>  false,
            'msg'       =>  '上传失败',
            'file_path' =>  '',
        ];
        //判断是否有上传文件
        if($file = $request->upload_file)
        {
            //传递参数为：上传图片，图片类型（目录），上传用户id,图片大小
            $request = $uploader->save($file, 'topics', Auth::id(), 1024);
            //如果图片保存成功的话
            if($request)
            {
                $data['success'] = true;
                $data['msg'] = '上传成功';
                $data['file_path'] = $request['path'];
            }
        }
        return $data;
    }
}
