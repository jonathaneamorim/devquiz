<?php

namespace app\exceptions;

// O Exception com o '\' no inicio devido ao arquivo atual estar dentro do namespace app, 
// se estiver sem o PHP vai procurar pela classe Exception dentro do mesmo namespace.
// Por isso o \ antes de Exception significa que você está se referindo à classe Exception do namespace global.
class ControllerNotExistsException extends \Exception{}