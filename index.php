<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Kerr's Jeopardy game</title>
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
        <link href="bootstrap.min.css" rel="stylesheet">
        <style>
            .row {
                margin-left: 20px;
                font-size: x-large;
            }
            .btn {
                font-size: large;
            }
        </style>
        <script type="text/javascript" src="jeopardy.js"></script>
    </head>
    <body onload="GetQuestion()">
        <div >	
            <div class="col-md-6">
                    <!--<img alt="image" src="" />-->
            </div>
            <div class="jumbotron text-center">
                <img src="Jeopardy.png" width="40%">
                <br><br>
                <h2>You've got a lot to learn</h2>			
            </div>	
        </div>
        <div class="row">
            <div class="col-sm-2">
                <label >Category: </label>
            </div>
            <div class="col-sm-10 font-weight-bold">
                <label id="lblCategory"></label>
                <input type="hidden" value="" id="catId"/>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2">Clue: </label>
            <div class="col-sm-10">
                <label id="lblClue" class="cols-sm-2"></label>        
                <input type="hidden" value="" id="qId"/><!--hidden question id field -->
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2">Dollar Value: </label>
            <div class="col-sm-10">        
                <label id="lblValue" class="cols-sm-2"></label>        
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2 control-label">Original Air Date: </label>
            <div class="col-sm-5">        
                <label id="lblAirDate" class="cols-sm-2"></label>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2 control-label">Your Score: </label>
            <div class="col-sm-5">        
                <label id="lblScore"></label>
                <input type="button" onclick="ResetScore()" name="button" id="button" value="Reset Score" class="btn btn-primary btn-sm login-button"/>
            </div>
        </div>
        <div class="row">
            <label for="response" class="col-sm-2">Response: </label><br>
            
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control" required name="txtResponse" id="txtResponse"  placeholder="ENTER YOUR RESPONSE HERE"/>
                    <input type="button" onclick="CheckAnswer()" name="button" id="btnSubmit" value="Submit" class="btn btn-primary btn-sm login-button"/>
                 </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-10">
                <input type="button" onclick="GetHint()" name="button" id="btnHint" value="Get Hint" class="btn btn-primary btn-sm login-button"/>
                <label id="lblHint"></label>
            </div>
        </div>
        <script>
            $("#btnCorrect").hide();
            $("#btnWrong").hide();
        </script>
    </body>
</html>