@extends('front.layouts.master')
@section('title', 'İletişim')
@section('bg', 'https://www.feke.bel.tr/tema/genel/uploads/arkaplan/arkaplan20/iletisim_1.jpg')
@section('content')
                <div class="col-md-10 col-lg-8 col-xl-7">
                    @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
                    @endif
                    @if($errors->any())
                        <div class=""alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
                </div>
                @endif
                    <p>Bizimle iletişime geçebilirsiniz.</p>
                    <form method="post" action="{{route('contact.post')}}">
                     @csrf
                    <div class="my-5">
                        <form>
                            <div class="form-floating">
                                <label>Ad Soyad</label>
                                <input type="text" class="form-control" id="name" value="{{old('name')}}" placeholder="Adınız Soyadınız" name="name" required >
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <div class="form-floating">
                                <label>Email Adresi</label>
                                <input class="form-control" id="email" type="email" value="{{old('name')}}" placeholder="Email Adresiniz" name="email" required>
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <div class="form-floating">
                                <label>Konu</label>
                                <br/>
                                <select class = "form-control" name="topic">
                                <option @if(old('topic')=="Bilgi") selected @endif>Bilgi</option>
                                <option @if(old('topic')=="Destek") selected @endif>Destek</option>
                                <option @if(old('topic')=="Genel") selected @endif>Genel</option>
                                </select>
                            </div>
                            <div class="form-floating">
                                <textarea rows="5" class="form-control" name="message" placeholder="Mesajınız">{{old('message')}}</textarea>
                                <label>Mesajınız</label>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                            <br />
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    To activate this form, sign up at
                                    <br />
                                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>

                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>

                            <button class="btn btn-primary text-uppercase" id="sendMessageButtton" type="submit">Gönder</button>
                        </form>
                    </div>

@endsection



