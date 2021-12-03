@extends('layout.app')
@section('title','Login')
@section('content')


<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">

        <div class="row">


            <!-- <div class="col-lg-4">
                    <div class="sidebar">
                        <h3 class="sidebar-title">Menu</h3>
                        <div class="sidebar-item categories">
                            <ul>
                                <li><a href="/login">Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div> -->

            <div class="col-lg-8 entries">
                <article class="entry entry-single">
                    <form id="formLogin">
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" form="formLogin">Login</button>
                    </div>
                </article><!-- End blog entry -->
            </div>
        </div>
    </div>
</section><!-- End Blog Single Section -->

@endsection

@section('script')
<script src="/assets/js/login.js"></script>
@endsection