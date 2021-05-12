<?php
HtmlHelper::formOpen('post', __WEB_ROOT . "/detail");
HtmlHelper::tag('h2', $title);
HtmlHelper::input('fullname', 'text', 'fullname', '', 'FullName', formCurrentValue('fullname'));
echo "<br>";
formError('fullname', '<span style="color: red">', '</span> ');
echo "<br>";

HtmlHelper::input('email', 'text', 'email', '', 'Email', formCurrentValue('email'));
echo "<br>";
formError('email', '<span style="color: red">', '</span> ');
echo "<br>";

HtmlHelper::input('pass', 'password', 'pass', '', 'Password', formCurrentValue('pass'));
echo "<br>";
formError('pass', '<span style="color: red">', '</span> ');
echo "<br>";

HtmlHelper::input('pass_confirm', 'password', 'pass_confirm', '', 'Confirm password', formCurrentValue('pass_confirm'));
echo "<br>";
formError('pass_confirm', '<span style="color: red">', '</span> ');
echo "<br>";

HtmlHelper::tag('button', 'Submit');
HtmlHelper::formClose();
?>