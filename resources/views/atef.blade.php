<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- <h1> {{ $ism }}  his age is {{ $omor }}</h1> --}}
Welcom view 
<h1><a href="{{ route('callali') }}">move to ali page</a></h1>



    <h1> 

        @if ($age==30)
        ikbirna
        @elseif ($age>30)
        khatyarna
        @else
            sghar bdna
        @endif  
    </h1>

    
    <h1> 

        @isset($age)
           age is set
        @endisset
    </h1>
    <h1> 

       @empty($age)
           age is emoty
       @endempty
    </h1>

    @if (@empty($age))
    age is empty
        
    @endif


    @foreach ($arr as $obj)
    <h1>
        {{ $obj['name'] }} his age is {{ $obj['age'] }}
    </h1>
    @endforeach

    @foreach ($data_names as $Name)
        <h1>{{ $Name['name'] }}</h1>
    @endforeach
</body>
</html>