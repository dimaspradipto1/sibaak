@extends('layouts.dashboard.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                    <li><i class="fa fa-window-maximize full-card"></i></li>
                    <li><i class="fa fa-minus minimize-card"></i></li>
                    <li><i class="fa fa-refresh reload-card"></i></li>
                    <li><i class="fa fa-trash close-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <h3 style="color: #104819; font-weight: bold; font-size: 30px;">Panduan Umum</h3>
                <br>
                <h4 style="color: #104819; font-weight: bold; font-size: 30px;">FAQ</h4>
                <div class="card-block accordion-block">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="headingOne">
                                <h1 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne" style="color: #104819; font-weight: bold; font-size: 20px;">
                                       Bagaimana cara mengakses Video Tutorial?
                                    </a>
                                </h1>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="accordion-content accordion-desc">
                                    <p>
                                        Video Tutorial dapat diakses di halaman utama SIBAAK, di bagian bawah halaman utama akan ada tombol "Video Tutorial" yang akan mengarah ke halaman Video Tutorial.
                                    </p>
                                </div>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="accordion-content accordion-desc">
                                    <p>
                                        Video Tutorial dapat diakses di halaman utama SIBAAK, di bagian bawah halaman utama akan ada tombol "Video Tutorial" yang akan mengarah ke halaman Video Tutorial.
                                        book. It has survived not only five
                                        centuries, but also the leap into
                                        electronic typesetting, remaining
                                        essentially unchanged. It was
                                        popularised in the 1960s with the
                                        release of Letraset sheets containing
                                        Lorem Ipsum passages, and more recently
                                        with desktop publishing software like
                                        Aldus PageMaker including versions of
                                        Lorem Ipsum.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="headingTwo">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo" style="color: #104819; font-weight: bold; font-size: 20px;">
                                        Informasi apa saja yang terdapat di Menu Arsip Tata Usaha?
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingTwo">
                                <div class="accordion-content accordion-desc">
                                    <p>
                                        Menu Arsip Tata Usaha BAAK berisi informasi tentang fitur-fitur yang tersedia di Sibaak.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="headingThree">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree" style="color: #104819; font-weight: bold; font-size: 20px;">
                                        Lorem Message 3
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingThree">
                                <div class="accordion-content accordion-desc">
                                    <p>
                                        Lorem Ipsum is simply dummy text of the
                                        printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard
                                        dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type
                                        and scrambled it to make a type specimen
                                        book. It has survived not only five
                                        centuries, but also the leap into
                                        electronic typesetting, remaining
                                        essentially unchanged. It was
                                        popularised in the 1960s with the
                                        release of Letraset sheets containing
                                        Lorem Ipsum passages, and more recently
                                        with desktop publishing software like
                                        Aldus PageMaker including versions of
                                        Lorem Ipsum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
