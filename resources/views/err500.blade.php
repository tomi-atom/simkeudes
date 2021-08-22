@extends('layouts.app')

@section('title')
@endsection

@section('breadcrumb')
    @parent
    <li>Underconstruction</li>
@endsection

@section('content')

 <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h2 class="headline text-red">3R</h2>

        <div class="error-content">
          <h2><i class="fa fa-warning text-red"></i> Oops! Website at under Construction</h2>

          <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href="{{ route('home') }}">return to dashboard</a>.
          </p>

          
        </div>
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>

@endsection