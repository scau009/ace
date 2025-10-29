# 监控服务使用文档

本项目使用 **Grafana Loki + Alloy + Grafana** 实现日志收集、存储和可视化查询。

## 架构说明

```
应用日志 ──┐
Nginx日志 ─┼─→ Alloy (采集) ─→ Loki (存储) ─→ Grafana (查询/可视化)
PHP日志 ──┘
```

### 组件说明

- **Loki**: 日志聚合系统，负责存储和索引日志（保留31天）
- **Alloy**: Grafana 新一代可观测性数据收集器，负责采集各类日志
- **Grafana**: 可视化平台，提供日志查询和仪表板

## 快速开始

### 1. 启动监控服务

```bash
# 启动所有服务（包括监控栈）
docker compose up -d

# 或只启动监控相关服务
docker compose up -d loki alloy grafana
```

### 2. 访问 Grafana

- **URL**: http://localhost:3000
- **默认账号**: admin
- **默认密码**: admin（首次登录会要求修改）

> 可以通过 `.env` 文件修改 Grafana 账号密码：
> ```env
> GRAFANA_ADMIN_USER=你的用户名
> GRAFANA_ADMIN_PASSWORD=你的密码
> ```

### 3. 查看日志

1. 登录 Grafana
2. 进入 **Explore** 页面（左侧菜单）
3. 选择数据源：**Loki**
4. 使用 LogQL 查询日志

## LogQL 查询示例

### 基础查询

```logql
# 查看所有 Symfony 应用日志
{job="symfony_app"}

# 查看 Nginx 访问日志
{job="nginx_access"}

# 查看 Nginx 错误日志
{job="nginx_error"}

# 查看 PHP-FPM 日志
{job="php_fpm"}
```

### 按环境过滤

```logql
# 查看开发环境日志
{job="symfony_app", env="dev"}

# 查看生产环境日志
{job="symfony_app", env="prod"}
```

### 按日志级别过滤

```logql
# 只看错误日志
{job="symfony_app", level="ERROR"}

# 查看警告和错误
{job="symfony_app"} |= "WARNING" or "ERROR"

# 排除 DEBUG 日志
{job="symfony_app", level!="DEBUG"}
```

### 按频道过滤

```logql
# 查看安全相关日志
{job="symfony_app", channel="security"}

# 查看请求日志
{job="symfony_app", channel="request"}

# 查看数据库日志
{job="symfony_app", channel="doctrine"}
```

### 内容搜索

```logql
# 搜索包含特定关键词的日志
{job="symfony_app"} |= "Exception"

# 正则表达式搜索
{job="symfony_app"} |~ "Error.*line \\d+"

# 排除特定内容
{job="symfony_app"} != "health check"
```

### HTTP 请求分析

```logql
# 查看 404 错误
{job="nginx_access", status="404"}

# 查看所有 5xx 错误
{job="nginx_access"} | status >= 500

# 查看特定路径的请求
{job="nginx_access", path="/api/users"}

# 查看 POST 请求
{job="nginx_access", method="POST"}
```

### 统计和聚合

```logql
# 统计错误数量
sum(count_over_time({job="symfony_app", level="ERROR"}[5m]))

# 按状态码统计请求
sum by (status) (count_over_time({job="nginx_access"}[1h]))

# 计算请求速率（每秒请求数）
rate({job="nginx_access"}[5m])

# 查看最近1小时的日志行数
count_over_time({job="symfony_app"}[1h])
```

### 时间范围

```logql
# 最近5分钟的错误
{job="symfony_app", level="ERROR"} [5m]

# 最近1小时的日志
{job="symfony_app"} [1h]

# 最近24小时
{job="symfony_app"} [24h]
```

## 日志收集说明

### Symfony 应用日志

- **路径**: `/var/www/html/var/log/*.log`
- **格式**: JSON（已配置 monolog.formatter.json）
- **包含字段**:
  - `message`: 日志消息
  - `level_name`: 日志级别（DEBUG, INFO, WARNING, ERROR, CRITICAL）
  - `channel`: 频道（app, security, request, doctrine 等）
  - `context`: 上下文信息
  - `extra`: 额外信息
  - `datetime`: 时间戳

### Nginx 访问日志

- **路径**: `/var/log/nginx/access.log`
- **解析字段**:
  - `remote_addr`: 客户端 IP
  - `method`: HTTP 方法（GET, POST 等）
  - `path`: 请求路径
  - `status`: HTTP 状态码
  - `body_bytes_sent`: 响应体大小
  - `http_referer`: 来源页面
  - `http_user_agent`: 用户代理

### Nginx 错误日志

- **路径**: `/var/log/nginx/error.log`
- **内容**: Nginx 服务器错误和警告信息

### PHP-FPM 日志

- **路径**: `/var/log/php-fpm/*.log`
- **内容**: PHP-FPM 进程管理和错误信息

## 服务端口

- **Grafana**: http://localhost:3000
- **Loki**: http://localhost:3100
- **Alloy**: http://localhost:12345

## 配置文件说明

### Loki 配置
- **文件**: `docker/loki/loki-config.yaml`
- **数据保留**: 31天（744小时）
- **存储**: 文件系统存储（使用 Docker volume）

### Alloy 配置
- **文件**: `docker/alloy/config.alloy`
- **语言**: Alloy Configuration Language
- **功能**: 定义日志源、解析规则、标签提取

### Grafana 数据源配置
- **文件**: `docker/grafana/provisioning/datasources/loki.yaml`
- **自动配置**: Grafana 启动时自动加载 Loki 数据源

## 常用命令

```bash
# 查看监控服务状态
docker compose ps loki alloy grafana

# 查看 Loki 日志
docker compose logs -f loki

# 查看 Alloy 日志
docker compose logs -f alloy

# 查看 Grafana 日志
docker compose logs -f grafana

# 重启监控服务
docker compose restart loki alloy grafana

# 停止监控服务
docker compose stop loki alloy grafana

# 清理日志数据（谨慎操作）
docker compose down
docker volume rm ace_loki_data ace_grafana_data
```

## 故障排查

### Grafana 无法连接 Loki

1. 检查 Loki 服务是否运行：
   ```bash
   docker compose ps loki
   ```

2. 检查 Loki 健康状态：
   ```bash
   curl http://localhost:3100/ready
   ```

3. 查看 Loki 日志：
   ```bash
   docker compose logs loki
   ```

### Alloy 无法采集日志

1. 检查 Alloy 服务状态：
   ```bash
   docker compose ps alloy
   ```

2. 查看 Alloy 日志：
   ```bash
   docker compose logs alloy
   ```

3. 验证日志文件路径是否正确：
   ```bash
   docker compose exec alloy ls -la /var/www/html/var/log/
   ```

### 查询无结果

1. 确认日志文件存在且有内容
2. 检查时间范围是否正确
3. 验证 LogQL 语法是否正确
4. 查看 Alloy 是否成功发送日志到 Loki

## 生产环境注意事项

1. **修改默认密码**: 务必修改 Grafana 管理员密码
2. **调整日志保留期**: 根据需求修改 Loki 配置中的 `retention_period`
3. **配置告警**: 在 Grafana 中配置日志告警规则
4. **监控磁盘空间**: 定期检查日志存储占用
5. **启用 HTTPS**: 生产环境建议配置 SSL/TLS
6. **访问控制**: 限制 Grafana 访问 IP 或配置反向代理

## 扩展功能

### 创建仪表板

1. 在 Grafana 中创建新 Dashboard
2. 添加面板，选择 Loki 数据源
3. 编写 LogQL 查询
4. 配置可视化类型（日志面板、图表、统计等）

### 配置告警

1. 在面板中点击 "Alert" 标签
2. 创建告警规则
3. 配置通知渠道（邮件、Slack、钉钉等）

### 导出日志

使用 LogCLI 工具或通过 Loki API 导出日志：

```bash
# 安装 LogCLI
brew install logcli  # macOS
# 或从 https://github.com/grafana/loki/releases 下载

# 导出日志
logcli query '{job="symfony_app"}' --addr=http://localhost:3100 --limit=5000 --output=jsonl > logs.json
```

## 参考资料

- [Grafana Loki 官方文档](https://grafana.com/docs/loki/latest/)
- [Grafana Alloy 官方文档](https://grafana.com/docs/alloy/latest/)
- [LogQL 查询语言](https://grafana.com/docs/loki/latest/logql/)
- [Grafana 官方文档](https://grafana.com/docs/grafana/latest/)
