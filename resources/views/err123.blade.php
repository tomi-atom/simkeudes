@extends('layouts.app')

@section('title')
    666 Error Conditions
@endsection

@section('breadcrumb')
    @parent
    <li>Pengabdian</li>
    <li>Pengusul</li>
    <li>Proposal</li>
    <li>666 Error</li>
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h2 class="headline text-red">666</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! Kesalahan pada proposal..</h3>

          <p>
            Kuota kegiatan telah penuh, judul kegiatan yang sama atau terkena pembatasan dari LPPM - Universitas Riau adalah punca halaman kesalahan ini muncul. Anda dapat menggunakan <a href="{{route('home')}}"> tautan ini</a> untuk kembali kehalaman depan..
          </p>

          
        </div>
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
