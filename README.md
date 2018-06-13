# Компонент Веб-формы БИТРИКС
 <p>Разработал более удобный комопонент для работы с веб-формами</p>
 <h3>Особенности:</h3>
 <ul>
 <li>Возможность выбора режима работы с использованием AJAX или без него</li>
 <li>Возможность выбора CAPTCHA (стандартная или Recaptcha v2)</li>
 <li>Возможность тонкой кастомизации шаблона</li>
 </ul>
 
 <h2>Установка</h2>
 <p>1. Разместите компонент (папка custom_form) в папке /local (или bitrix)/components/<--ваше пространство имен-->/</p>
 <p>2. Разместите reload_captcha.php в папке /ajax/</p>
 
 <h2>Для полноценной работы необходимо уставноить:</h2>
 <ul>
  <li>Recaptcha v2: <a href="https://github.com/google/recaptcha">Recaptcha GitHub</a></li>
  <ul>
   <li>Из папки /src/ скопировать содержимое в папку /php_interface/include/ (если папки include нет, то необходимо ее создать)</li>
   <li>Получить ключи <a href="https://www.google.com/recaptcha/">Recaptcha Google</a></li>
   <li>В php_interface/init.php установить константы:</li>
   
   ```php
   @require_once 'include/autoload.php';
   define("RE_SITE_KEY","6-----------ключ----------7K");
   define("RE_SEC_KEY","6--------секретный ключ-----B");
   ```
   
  </ul>
  <li>Добавить скрипт масок для полей формы: <a href="https://itchief.ru/lessons/javascript/input-mask-for-html-input-element">MaskedInput JS</a></li>
  <li>Добавить <a href="http://parsleyjs.org/doc/download.html">Parsley JS</a> для валидации формы </li>
 </ul>
