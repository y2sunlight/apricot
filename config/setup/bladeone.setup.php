<?php
//-------------------------------------------------------------------
// View template (BladeOne)の初期設定
//-------------------------------------------------------------------
return function():bool
{
    // @now directive
    Apricot\View::directive('now', function()
    {
        return "<?php echo date('Y-m-d H:i'); ?>";
    });

    // @csrf directive
    Apricot\View::directive('csrf', function()
    {
        $name = Apricot\Foundation\Security\CsrfToken::CSRF_KEY;
        return '<input name="'.$name.'" type="hidden" value="{{Session(\''.$name.'\')}}">';
    });

    return true; // Must return true on success
};