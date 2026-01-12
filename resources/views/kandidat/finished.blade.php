@extends('layouts.kandidat')

@section('title','Tes Selesai')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow border-0 text-center">
                <div class="card-body py-5">

                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success fa-4x"></i>
                    </div>

                    <h3 class="font-weight-bold mb-2">
                        Tes Psikotes Telah Selesai
                    </h3>

                    <p class="text-muted mb-4">
                        Terima kasih telah mengikuti seluruh rangkaian psikotes.
                        Jawaban Anda telah berhasil disimpan dan akan diproses oleh tim HRD.
                    </p>

                    <div class="alert alert-info text-left">
                        <ul class="mb-0">
                            <li>Anda tidak perlu mengulang tes.</li>
                            <li>Hasil akan diinformasikan oleh pihak HRD.</li>
                            <li>Pastikan Anda menunggu informasi selanjutnya.</li>
                        </ul>
                    </div>

                    <hr>

                    <p class="small text-muted mb-0">
                        Jika Anda mengalami kendala teknis selama tes, silakan hubungi panitia.
                    </p>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
