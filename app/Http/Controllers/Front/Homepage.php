<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Validator;

//Models
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Contact;



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
public function contactpost(Request $request){
        $rules=[
            'name'=>'required|min:3',
            'email'=>'required|email',
            'topic'=>'required',
            'message'=>'required|min:10',
        ];
        $validate=Validator::make($request->post(),$rules);

        if($validate->fails()){
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        Mail::send([],[], function($message) use($request){
        $message->from('iletisim@blogsitesi.com','Blog Sitesi');
        $message->to('rumeysaa.kocakk8@gmail.com');
        $message->setBody('5555','text/html');
        $message->subject($request->name. ' iletişimden mesaj gönderdi!');
    });
        //contact = new Contact;
        //contact->name=$request->name;
        //contact->email=$request->email;
       //$contact->topic=$request->topic;
        //contact->message=$request->message;
        //contact->save();
        return redirect()->route('contact')->with('success','Mesajınız bize iletildi. Teşşekür ederiz!');
}
}
