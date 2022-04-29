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
                                    <h4 class="card-title">Managemen User</h4>
                                </div>
                                <div class="col">
                                    <span class="d-flex justify-content-end">
                                        <a href="javascript:;" class="btn btn-primary" onclick="user.addNew()"><i class="fas fa-plus me-2"></i> Tambah Data</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="tb-user">
                                <thead>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Username</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <input type="hidden" name="idUser" id="idUser" class="form-control">
                            <div class="invalid-feedback" id="usernameFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" name="password" id="password" class="form-control">
                            <div class="invalid-feedback" id="passwordFeedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Batal</button>
                    <button type="button" class="btn btn-outline-primary btn-submit" data-csrf="{{ csrf_token() }}"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSettingUser" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="profilNameUser" class="form-label">Nama Profil</label>
                            <input type="text" name="profilNameUser" id="profilNameUser" class="form-control">
                            <input type="hidden" name="idProfilUser" id="idProfilUser" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nikUser" class="form-label">NIK</label>
                            <input type="text" name="nikUser" id="nikUser" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Batal</button>
                    <button type="button" class="btn btn-outline-primary btn-submit-profil" data-csrf="{{ csrf_token() }}"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
