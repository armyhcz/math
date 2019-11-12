# math
 + chiness math expression

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

// todo + - * / 
// 可自己扩展操作,前提操作符为单个字符,切继承基类
class AndOperation extends \China\Math\Calculation\AbstractOperation {

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string {
        return \China\Math\Number\Formatter::format($left === $right ? 1 : 2, $this->scale);
    }

}

// 添加操作符,设置权重,设置绑定类
$symbol = (new \China\Math\Expression\Calculator\Symbol())->setSymbol('&')
    ->setWeight('&', 2)->setOperation('&', AndOperation::class);

// 使用
$stack = (new \China\Math\Expression\Calculator($symbol))->pattern('(a+b+c)*d-f*m&o');

$result = $stack->calc(array(
    'a' => 3,
    'b' => 4,
    'c' => 5,
    'd' => 6,
    'f' => 4,
    'm' => 5,
    'o' => 0,
), 5);
```

+ 日志未完成
