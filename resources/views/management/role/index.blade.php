@extends('layouts.main')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageHead }}</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">Managemen User Role</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" aria-label="Username" readonly>
                                        <a href="javascript:;" class="btn btn-primary" id="btn-search"><i class="fas fa-search me-2"></i> Cari</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="jstree-role"></div>
                                    <div class="form-group" style="margin-top: 20px;">
                                        <a href="javascript:;" class="btn btn-primary d-none" id="simpan-jstree" data-csrf="{{ csrf_token() }}"><i class="fas fa-save me-2"></i>Simpan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="tb-user">
                        <thead>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Username</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
