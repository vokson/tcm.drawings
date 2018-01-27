<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Чертежи АГПЗ</title>
    {{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
</head>

<body>
<table>

    @php
        $doc_id = 0;
    @endphp

    @if (count($data['files']) === 0)
        Пусто !!!
    @else
        @foreach ($data['files'] as $file)

            @php
                $ext = pathinfo($file, PATHINFO_EXTENSION);

                $pdfExtensions = ['pdf', 'PDF'];
                $wordExtensions = ['doc', 'DOC', 'docx', 'DOCX'];
                $excelExtensions = ['xls', 'XLS', 'xlsx', 'XLSX', 'xlsm', 'XLSM'];
                $zipExtensions = ['zip', 'ZIP'];
                $color = '';
                $text = '';

                if (in_array($ext, $pdfExtensions)) {$color = 'purple'; $text = 'PDF';}
                if (in_array($ext, $wordExtensions)) {$color = 'blue'; $text = 'WORD';}
                if (in_array($ext, $excelExtensions)) {$color = 'green'; $text = 'EXCEL';}
                if (in_array($ext, $zipExtensions)) {$color = 'red'; $text = 'ZIP';}
            @endphp

            @if ($ext !== 'json' && $ext !== 'JSON')
                <tr>
                    <td>
                        <font color="{{$color}}">{{ $text }} : </font>
                    </td>

                    <td>
                        <a href="/transmittals/{{ $data['trans_id'] }}/files/{{ $doc_id }}">{{ basename($file) }}</a>
                    </td>
                </tr>
            @endif


            @php
                $doc_id++;
            @endphp

        @endforeach
    @endif

</table>
</body>


</html>