<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>
    <div class="container mt-5">
<form action="{{route('insert')}}" method="POST">
    <div class="mb-3">
      <label class="form-label">firstName</label>
      <input type="text" name="firstName">
    </div>
    <div class="mb-3">
        <label  class="form-label">lastName</label>
        <input type="text" name="lastName">
    </div>
    <div class="mb-3">
        <label class="form-label">years of experience</label>
        <input type="number" name="yearOfExperience">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    </div>
</body>