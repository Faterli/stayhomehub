<?php
namespace App\Observers;
use App\Models\View;
class ViewObserver
{
    public function created(View $view)
    {
        $view->video->view_count = $view->video->view->count();
        $view->video->save();

    }
    public function deleted(View $view)
    {
        $view->video->view_count = $view->video->view->count();
        $view->video->save();
    }
}
