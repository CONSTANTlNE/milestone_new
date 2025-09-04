<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>New Individual Quotation </h1>

<p>{{$quotation->email}}</p>
<p>{{$quotation->phone}}</p>

<table width="100%">
    <tbody>
    <thead>
    <tr>
        <th style="font-size: 12px">Start</th>
        <th style="font-size: 12px">Destination</th>
        <th style="font-size: 12px">Car</th>
    </tr>
    </thead>
        <tr>
            <td>
                <p style="text-align:center;color:#5f6499;font-size:12px;margin-bottom:0">
                    {{$quotation->start_address}}
                </p>
            </td>
            <td>
                <p style="text-align:center;color:#5f6499;font-size:12px;margin-bottom:0">
                    {{$quotation->destination_address}}
                </p>
            </td>
            <td>
                <p style="text-align:center;color:#5f6499;font-size:12px;margin-bottom:0">
                    {{$quotation->vehicle}}
                </p>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
