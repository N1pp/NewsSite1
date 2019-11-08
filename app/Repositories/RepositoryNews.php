<?php
/**
 *
 *
 * https://yksweb.ru
 * Created by gorbachevda (gorbachev@yksoft.ru)
 * Date: 08.11.2019
 */

namespace App\Repositories;


use App\Image;
use App\News;
use App\NewsTags;
use App\Ratings;
use App\Tags;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RepositoryNews
{
    private $news;

    public function __construct(array $data, string $tags,array $images)
    {
        $news = new News;
        $news->title = $data['title'];
        $news->content = $data['content'];
        $news->user_id = Auth::id();
        $news->save();
        $this->news = $news;
        $this->addTags($tags);
        $this->addImages($images);
    }

    public function addTags(string $tags)
    {
        $tags = explode(',', $tags);
        foreach ($tags as $str) {
            if (Tags::where('name', trim($str))->get()->first()) {
                $nt = new NewsTags;
                $nt->news_id = $this->news->id;
                $nt->tags_id = Tags::where('name', trim($str))->get()->first()->id;
                $nt->save();
            } else {
                $tag = new Tags;
                $tag->name = trim($str);
                $tag->save();
                $nt = new NewsTags;
                $nt->news_id = $this->news->id;
                $nt->tags_id = Tags::where('name', trim($str))->get()->first()->id;
                $nt->save();
            }
        }
    }

    public static function deleteNews($id)
    {
        News::where('id', $id)->delete();
        foreach (Image::where('news_id', $id)->get() as $image) {
            Storage::delete('public/' . $image->path);
            $image->delete();
        }
    }

    public function addImages(array $images)
    {
        if ($images) {
            foreach ($images as $im) {
                $path = $im->store('uploads', 'public');
                $img = new Image();
                $img->path = $path;
                $img->news_id = $this->news->id;
                $img->save();
            }
        }
    }

    public function getNews()
    {
        return $this->news;
    }

    public static function voteUp($news)
    {

    }

    public static function voteDown($news)
    {

    }
}
