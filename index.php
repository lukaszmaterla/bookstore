<html>
    <head>
        <title>Library</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="form-group">
                <h3>Dodaj książkę</h3>
                <form>
                    Autor:<br>
                    <input type="text" class="form-control" name="author"/>
                    <hr>
                    Tytuł:<br>
                    <input type="text" class="form-control" name="title"/>
                    <hr>
                    Opis:<br>
                    <textarea class="form-control" name="description"></textarea>
                    <hr>
                    <button id="addBook" class="btn btn-success">Dodaj książkę</button>
                </form>
            </div>

            <h3>Lista książęk</h3>
            <div id="books">
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>

