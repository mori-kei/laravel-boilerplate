# Lv5

havingについて学んで以下を解きましょう。

1. 各チームのタスク数を求め、タスク数が2以上のチームのみを表示してください。
```sql
SELECT teams.*, COUNT(tasks.id) 
FROM teams
JOIN tasks ON teams.id = tasks.team_id
GROUP BY teams.id
HAVING COUNT(tasks.id) >= 2;
```
2. 各チームのメンバー数を求め、メンバー数が5以上のチームのみを表示してください。
```sql
SELECT teams.* ,COUNT(members.id)
FROM teams
JOIN members ON teams.id  = members.team_id 
GROUP BY teams.id 
HAVING COUNT(members.id) >= 5;
```
3. 各ユーザーに割り当てられたタスク数を求め、タスク数が3以上のユーザーのみを表示してください。
```sql
SELECT users.* ,COUNT(tasks.id) 
FROM  users JOIN tasks  ON users.id = tasks.assignee_id 
GROUP BY users.id 
HAVING  count(tasks.id) >= 3;
```
4. 各タスクのコメント数を求め、コメント数が5以上のタスクのみを表示してください。

```sql
SELECT tasks.*, COUNT(comments.id)
FROM tasks 
JOIN comments ON tasks.id = comments.task_id 
GROUP BY tasks.id 
HAVING COUNT(comments.id)  >= 5;
```





