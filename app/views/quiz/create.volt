<div class="container">
    <form class="form" method="post" action="">
        <div class="form-group">
            <label for="quizName">Quiz name</label>
            <input type="text" class="form-control" id="quizName" placeholder="" name="name">

        </div>
        <div class="form-group">
            <label for="quizQuestionsCount">Questions count</label>
            <input type="number" class="form-control" id="quizQuestionsCount" aria-describedby="quizHelp" name="question_count" min="1" max="30" onkeypress="return event.charCode >= 48">
            <small id="quizHelp" class="form-text text-muted">This is simulation. Quiz will be created with specified amount of questions. Correct answers will be selected absolutely random.</small>
        </div>
        <button type="submit" class="btn btn-primary">Create Quiz</button>
    </form>
</div>