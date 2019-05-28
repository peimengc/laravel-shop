<?php

return [
    'alipay' => [
        'app_id' => '2016093000628421',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAo2fF5VDaAG3Sm6auVFT74bXaae5TlMKL5kJakQWLrM0Z5Ytb4rRCmO6OTKldK5zlaS0Aqgwv9nmDOJEatfHYpHYZpgc7z9/rPsNxzdpncoD+Y7lxFY/hfGe4xeaP3xUukUdCwK8oQVgwXS7Qb5sifi7trxqos+69KiZK1YnLCIScd9Jnk7fLJLMa/AXGwkl4Tnu5ZNxIjm9ucGEnFDS08ZactbVRCI63Y654dV26ZBkdkGM4MeWKjzFHL/PqNDSD3YlXEp+hztn3OxqsbVOX88juT5rX+HWmfHdhkAWF26jPyZIej6x6BsagizsedkjbgN2toYO/Pr9NU9s09Zxm7QIDAQAB',
        'private_key' => 'MIIEowIBAAKCAQEAtQBVdznIC9CruGtAdSGn+h4peeMVyOO3vhTcBEHoTTl1b5tcdqmgR4NaOuIs7PYEV2XkGmp0jy4Hoy9iAc6R+ynbFVhbCBqC6dHWhtXg0S9jyCEKuzGraMvRCwOAyEUuyE1ecOXe37qzkHLCePbGTTVhMeXJc6bW8s+1hyTKhvzwi+yBSKH4zwnWwOOVjX+0maaN5pCeDAVrycbXPln02bDiQKp8u7i8l8r+IkWO5EB+lPEtmVNiGhRMipiSLxzX5hXrrQXOJNsa/uLAl0E6oqR6q4Yr2Xu90YZxS9RuLEZMtjM3PJ5ckXX5qMNyKkt3qvGzvnLZuERIbX+k5q106QIDAQABAoIBADmerJZy14MjX7cqtW9UUoQmG/AIYYP9Mh4Zx9y3GnuTAhaQb8P6xeJeJ1g9bi3VN5aXAiGCqC54acgCKoIGv6QkM/E8mmYfAnPq8A8mgRY2rt4j3qWu7zFCSP7nk5StqXHsZ1crZmL0rXsbfVtCu+gSSSm4TAQ8JYtQoiouhSapT9w8rVqhNTlJ83k6OOEQTLIxS4yhBdXxJOD94fKniDfYhIJyDm1JdkYWuQ+kfwahJMfo29DWBfu2tk98+C/FZNfc0YXeZH/VitnE91nx8bOCnX5hNcJLnRHTM8KhqBTZrCsXzuf09kb+TTdprurxkXFZzKaGKRuN1QDKEUS8h7ECgYEA2sICrOFAIUsFtfkZbYkcKhw+7wDffA2fHu7cOZVLkZ83oNfAVr9QiNQwU5O+zpEywU6kP601kmTtHCQTYk0BD+DCrpkcJ9B+CCUSAcq5qznTFM+TEYEjqnoPwL3eEU7X+TnbAwwDkvLVpiDIR9j+3GK+c+Cu5MRutRly6isiY3UCgYEA09DNhtBDhe9kszPSuEc5ZQi/vQ8ifpZrXsGUrIBJoZttI+AHrD7wb1ry6f2qfLM0FGgvEPh/18KkYowzGejvov9agqGHIy3rZB1d7bKvJjVpr/YA6vZfIGqp5lBSh7tiHeDwSOfH2raI0DpPVkmWX0rcJBgW70ZUa972p273ISUCgYA2fCn0aynw4OGsQD3AFW1JY72dA6emGzJtnuqFARVQUMqnKfWC5aWmXssmld7pTirJENBB998m9jJEVwvo6OsBzGZQ3Fux4vDxEGKaxaZW6lETltu3eWWruTkhNWkRAIU0Ut+ks6JUQF1MQk//7SEVPRbYf7avzekQ/CSuBE5NXQKBgDQcC2QeOm5p3bFEj5OsWg9kHp+paIgSA2o1X5ksmnC6pxgLVnfmqAoNKvOr51R0VdyrYODg8bqn9P8VlMDMEKBeB+tZR8C83Est+lyu9+4Dd/PFJqanY/G6q/+wRQ2FaPcGzrZw5zcEbxYjMj99LRRWe2AZ2RKWj9BV8wJwBzZNAoGBANaAxUfw8e8XxOeEYkX+8RC2/g7ESTkxuDDdz5o5Pn5gF/SlZuFB6Ij7SPj1zHMDHrY4uN2JOgyD6bWfvXNO3oijYr+L6wrnVmvcg+icNC06Dl4mKzK5iYjz+d5f6npd/vRf0EGH3BHvcthYOakQplcdvB5ZZUyUhCNrDttt1zW4',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_client' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];