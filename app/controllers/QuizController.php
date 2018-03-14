<?php
class QuizController extends ControllerBase
{
    public function indexAction()
    {
        $this->session->remove ('quiz_id');
        try
        {
            $page           = $this->request->getQuery ('page');
            $quizList       = (new \Quiz\Quiz\Quiz())->getQuizList();

            $paginator      = new \Phalcon\Paginator\Adapter\NativeArray (
                [
                    'data'          => $quizList,
                    'page'          => $page,
                    'limit'         => \Quiz\Utility\Base::DEFAULT_PAGE_LIMIT,
                ]
            );

            $this->view->setVar ('paginator', $paginator);
        }
        catch (\QuizException | \QuestionException | \Exception $e)
        {
            echo 'An error acquired: ' . $e->getMessage();
            echo '<span style="color:#fff;">' . $e->getTraceAsString() . '</span>';
            exit;
        }
    }

    public function createAction()
    {
        if ($this->request->isPost())
        {
            try
            {
                (new \Quiz\Quiz\Quiz())->createFakeQuiz($this->request->getPost());
            }
            catch (\Exception $e)
            {
                echo $e->getMessage();
                exit;
            }
        }
    }

    public function takeAction (int $quizId)
    {
        $this->view->setVar ('body_properties', ' onload="init();"');
        $questions  = (new \Quiz\Quiz\Quiz())->renderQuiz($quizId);

        $this->view->setVar ('questions', json_encode ($questions));
        $this->view->setVar ('quiz_id', $quizId);
    }

    public function checkAction($quizId)
    {
        $result     = $this->request->getPost('result');

        try
        {
            $score      = (new \Quiz\Quiz\Quiz())->examination($quizId, $result);
            echo 'You results was successfully stored. Your score: ' . $score . '%';
            exit;
        }
        catch (\Exception | \QuizException $e)
        {
            echo $e->getMessage();
            exit;
        }


    }
}