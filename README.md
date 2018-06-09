# Компонент Веб-формы БИТРИКС
 Разработал более удобный комопонент для работы с веб-формами
 
 <h4>Для корректной работы необходимо уставноить:</h4>
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
 </ul>
