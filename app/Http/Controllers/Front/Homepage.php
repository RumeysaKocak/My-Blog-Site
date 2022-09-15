<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;

class Homepage extends Controller
{
    public function _construct(){
        view()->share('pages',Page::orderBy('order','ASC')->get());
    }
    public function index(){
        $data['articles']=Article::orderBy('created_at','DESC')->paginate(2);
        $data['articles']->withPath(url('sayfa'));
        $data['categories']=Category::inRandomOrder()->get();
        $data['pages']=Page::orderby('order','ASC')->get();
        return view('front.homepage', $data);
    }


    public function single($category,$slug){
        $pages=Page::all();
        $category = Category::whereSlug($category)->first() ?? abort(404,'Böyle bir yazı bulunamadı');
        $article =Article::whereSlug($slug)-> whereCategoryId($category->id)->first() ?? abort(404,'Böyle bir yazı bulunmadı');
        $article->increment('hit');
        $data['articles']=$article;
        $data['categories']=Category::inRandomOrder()->get();

        return view('front.single',compact('data','pages','article'));
    }
public function category($slug){

    $category = Category::whereSlug($slug)->first() ?? abort(404,'Böyle bir yazı bulunamadı');
    $data['category'] = $category;
    $data['articles'] = Article::where('category_id', $category->id)->orderBy('created_at', 'DESC')->paginate(1);
    $data['categories'] = Category::inRandomOrder()->get();
    $data['pages'] = Page::orderby('order','ASC')->get();

    return view('front.widgets.category',$data);
}
public function page($slug){
        $page=Page::whereSlug($slug)->first() ?? abort(404, 'Böyle bir sayfa bulunamadı');
        $data['page']=$page;
        $data['pages']=Page::orderby('order','ASC')->get();
        return view('front.page',$data);
}
public function contact(){
    $data['pages'] = Page::orderby('order','ASC')->get();
    return view('front.contact',$data);
}
}
