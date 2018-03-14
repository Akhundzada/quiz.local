<div class="container" style="margin-top: 1%;">
    <form method="post" action="">
        <input type="submit" name="btn-submit" class="btn btn-primary" value="Submit Result" disabled id="submit-btn">
    </form>
    <canvas id="quizCanvas" width="500" height="1100"></canvas>
</div>

<script type="text/javascript">
    function init()
    {
        stage = new createjs.Stage("quizCanvas");
        result = [];
        var question = drawCircle('LightGray', 15, 15);

        questionsArray  = JSON.parse('{{ questions }}');
        var qIterator       = 1;

        for (var qIdx in questionsArray)
        {
            var question = drawCircle('Black', 15, (qIterator+1) * 35, qIterator, '#fff', false);
            stage.addChild(question);


            for (var j = 0; j < questionsArray[qIdx].length; j++)
            {
                var answer = drawCircle('LightGray', (j+1) * 60, (qIterator+1) * 35, questionsArray[qIdx][j]['name'], '#000', true, qIdx, questionsArray[qIdx][j]['id']);
                stage.addChild(answer);
            }

            qIterator++;
        }

        stage.enableMouseOver();
        stage.update();

    }

    function drawCircle (color, positionX, positionY, _text, _textColor, isIteractable, qid, aid)
    {
        var container = new createjs.Container();
        var circle = new createjs.Shape();
        circle.graphics.beginFill(color).drawCircle(0, 0, 15);
        circle.x = positionX;
        circle.y = positionY;

        var text = new createjs.Text(_text, "18px Arial", _textColor);

        text.set({
            textAlign: "center",
            textBaseline: "middle",
            x: positionX,
            y: positionY
        });


        if (true === isIteractable)
        {
            container.name = "answer_" + aid;

            container.on("click", function(event){
                var toChangeColor = circle.graphics._fill.style === color ? 'orange' : color;

                if (typeof result[qid] !== "undefined" && result[qid] !== -1)
                {
                    var _child = stage.getChildByName ("answer_" + result[qid]);
                    _child.getChildAt(0).graphics.beginFill('lightgray').drawCircle(0, 0, 15);
                }

                if (toChangeColor === 'orange')
                {
                    result[qid] = aid;
                }
                else
                {
                    result[qid] = -1;
                }

                circle.graphics.beginFill(toChangeColor).drawCircle(0, 0, 15);
                stage.update();

                if (result.length - 1 === Object.keys(questionsArray).length)
                {
                    $('#submit-btn').attr('disabled', false);
                }
            });

            container.on("mouseover", function(event){
                container.cursor = "pointer";
            });

        }

        container.addChild (circle, text);

        return container;
    }

    $(document).ready(function()
    {
        $('#submit-btn').click(function(e)
        {
            e.preventDefault();
            $.post ('/quiz/check/{{ quiz_id }}', { result: result }, function(message)
            {
                alert (message);
                window.location.href = '/quiz';
            });
            return false;
        })
    })

</script>
