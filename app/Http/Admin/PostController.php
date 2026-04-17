<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'content'     => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_published'=> 'nullable|boolean',
        ], [
            'title.required'   => 'Vui lòng nhập tiêu đề bài viết.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'thumbnail.image'  => 'File phải là ảnh.',
            'thumbnail.max'    => 'Ảnh tối đa 3MB.',
        ]);

        // Tạo slug duy nhất
        $slug = Str::slug($request->title);
        $base = $slug;
        $i    = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $data = [
            'title'      => $request->title,
            'slug'       => $slug,
            'excerpt'    => $request->excerpt,
            'content'    => $request->content,
            'author_id'  => auth()->id(),
            'is_published' => $request->boolean('is_published', true),
        ];

        // Upload thumbnail
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Đăng bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'content'     => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_published'=> 'nullable|boolean',
        ]);

        $data = [
            'title'        => $request->title,
            'excerpt'      => $request->excerpt,
            'content'      => $request->content,
            'is_published' => $request->boolean('is_published', true),
        ];

        // Upload thumbnail mới
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // Xóa ảnh cũ
            if ($post->thumbnail) {
                \Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        // Xóa thumbnail
        if ($request->input('remove_thumbnail') == '1' && $post->thumbnail) {
            \Storage::disk('public')->delete($post->thumbnail);
            $data['thumbnail'] = null;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->thumbnail) {
            \Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Xóa bài viết thành công!');
    }

    public function togglePublish($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['is_published' => !$post->is_published]);
        return back()->with('success', $post->is_published ? 'Đã công khai bài viết.' : 'Đã ẩn bài viết.');
    }
}
