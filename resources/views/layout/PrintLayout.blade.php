<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="container-md" style="height:100vh; display:flex; flex-direction:column; justify-content:space-between">
        <a class="btn btn-primary mb-3" href="/dashboard/terimapinjam" id="btn-dashboard"
            style="display:none; width:fit-content;">
            Kembali ke Dashboard
        </a>
        <div class="row" style="flex:0 1 auto;">
            <div class="mb-3 d-flex justify-content-between">
                <div class="d-flex gap-3 align-items-center">
                    <img src="{{ asset('storage/' . $report->perusahaan->image) }}" alt=""
                        style="max-width: 180px; max-height: 65px; height: 100%">
                    <header class="d-flex flex-column justify-content-start">
                        <strong class="text-uppercase" style="font-size: 16px">
                            {{ $report->perusahaan->nama_perusahaan }}
                        </strong>
                        <strong style="font-size: 16px">Jl. Ir. H. Juanda III No. 8</strong>
                        <strong style="font-size: 16px">Jakarta Pusat 10120</strong>
                    </header>
                </div>
                <p class="text-end text-muted">
                    No: {{ $report->perusahaan->id }}000{{ $report->id }}
                </p>
            </div>
            <hr style="border-top: 2px solid black;  background: #ffffff;" class="" />
            <div class="row">
                <div class="container">
                    @yield('content')
                </div>
            </div>
            <hr style="border-top: 2px dashed black; background: #ffffff;" class="" />
            <div class="row">
                <div class="text-start">
                    <p style="font-size: 18px; font-weight:500;" class="mb-0">
                        Jakarta, {{ \Carbon\Carbon::parse($report->terakhir_cetak)->format('d M Y') }}
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="col text-start">Dikirim oleh</td>
                                <td class="col text-end">Diterima oleh</td>
                            </tr>
                            <tr style="height: 60px; background: #ffffff">
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td class="col text-start">( {{ $report->pengirim }} )</td>
                                <td class="col text-end">( {{ $report->penerima }} )</td>
                            </tr>
                        </tbody>
                    </table>
                    {{--  --}}
                </div>
            </div>
        </div>
        {{--  --}}
        {{-- <div class="row my-5"></div> --}}
        {{--  --}}
        <div class="row" style="flex:0 1 auto;">
            <div class="mb-3 d-flex justify-content-between">
                <div class="d-flex gap-3 align-items-center">
                    <img src="{{ asset('storage/' . $report->perusahaan->image) }}" alt=""
                        style="max-width: 180px; max-height: 65px; height: 100%">
                    <header class="d-flex flex-column justify-content-start">
                        <strong class="text-uppercase" style="font-size: 16px">
                            {{ $report->perusahaan->nama_perusahaan }}
                        </strong>
                        <strong style="font-size: 16px">Jl. Ir. H. Juanda III No. 8</strong>
                        <strong style="font-size: 16px">Jakarta Pusat 10120</strong>
                    </header>
                </div>
                <p class="text-end text-muted">
                    No: {{ $report->perusahaan->id }}000{{ $report->id }}
                </p>
            </div>
            <hr style="border-top: 2px solid black;  background: #ffffff;" class="" />
            <div class="row">
                <div class="container">
                    @yield('content')
                </div>
            </div>
            <hr style="border-top: 2px dashed black; background: #ffffff;" class="" />
            <div class="row">
                <div class="text-start">
                    <p style="font-size: 18px; font-weight:500;" class="mb-0">
                        Jakarta, {{ \Carbon\Carbon::parse($report->terakhir_cetak)->format('d M Y') }}
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="col text-start">Dikirim oleh</td>
                                <td class="col text-end">Diterima oleh</td>
                            </tr>
                            <tr style="height: 60px; background: #ffffff">
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td class="col text-start">( {{ $report->pengirim }} )</td>
                                <td class="col text-end">( {{ $report->penerima }} )</td>
                            </tr>
                        </tbody>
                    </table>
                    {{--  --}}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        function timeoutToDashboard() {
            document.getElementById('btn-dashboard').style.display = 'inline-block';
        }

        window.print()
        setTimeout(() => {
            timeoutToDashboard();
        }, 5000);
    </script>
</body>

</html>
