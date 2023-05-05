<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>
    <div class="container mt-5">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
                <th scope="col">Years Of Exp</th>
                {{-- <th scope="col">Type</th> --}}
              </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $key => $candidat)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$candidat->firstName}}</td>
                    <td>{{$candidat->lastName}}</td>
                    <td>{{$candidat->yearOfExperience}}</td>
                    {{-- <td>{{$candidat->attribute->type}}</td> --}}
                  </tr>
                @endforeach
              
              
            </tbody>
          </table>
    </div>
</body>