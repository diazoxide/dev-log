# Dev-log
Powerful tool to debug your code runtime

To use dev-log you must prepend this code on your index.php

```php
include_once "dev-log/autoloader.php";
```


Examples of usage

```php

\DevLog\DevLog::warning("warning");
\DevLog\DevLog::error("error");
\DevLog\DevLog::info("info");
\DevLog\DevLog::important("important");
\DevLog\DevLog::note("note");
\DevLog\DevLog::secondary("secondary");

```

