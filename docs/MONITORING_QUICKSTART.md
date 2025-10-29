# 监控服务快速启动指南

## 一键启动

```bash
# 启动所有服务（包括监控）
docker compose up -d

# 等待服务启动（约30秒）
docker compose ps
```

## 验证服务

```bash
# 检查所有监控服务是否正常运行
docker compose ps loki alloy grafana

# 应该看到三个服务都是 "running" 状态
```

## 访问 Grafana

1. 打开浏览器访问: **http://localhost:3000**
2. 登录信息:
   - 用户名: `admin`
   - 密码: `admin` (首次登录会要求修改)

## 查看日志

1. 在 Grafana 左侧菜单点击 **Explore** (放大镜图标)
2. 确认数据源已选择 **Loki**
3. 在查询框输入以下查询:

```logql
{job="symfony_app"}
```

4. 点击 **Run query** 按钮或按 `Shift + Enter`

## 常用查询模板

复制粘贴到 Grafana 查询框即可使用:

```logql
# 查看所有应用日志
{job="symfony_app"}

# 只看错误日志
{job="symfony_app", level="ERROR"}

# 查看 Nginx 访问日志
{job="nginx_access"}

# 查看 5xx 错误
{job="nginx_access", status=~"5.."}
```

## 如果没有日志显示

1. 生成一些日志:
   ```bash
   # 访问应用生成日志
   curl http://localhost:8080

   # 或访问不存在的页面生成404错误
   curl http://localhost:8080/nonexistent
   ```

2. 检查日志文件是否生成:
   ```bash
   docker compose exec php ls -la var/log/
   ```

3. 检查 Alloy 是否正常采集:
   ```bash
   docker compose logs alloy | tail -20
   ```

## 停止监控服务

```bash
# 停止所有服务
docker compose down

# 或只停止监控服务
docker compose stop loki alloy grafana
```

## 更多信息

详细使用文档请查看: [MONITORING.md](./MONITORING.md)
