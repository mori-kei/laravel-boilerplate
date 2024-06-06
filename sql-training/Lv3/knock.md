# Lv. 3

1. **特定のユーザーが書いた全てのコメントを取得するクエリを書いてください。**
```sql
SELECT * 
FROM  comments 
WHERE author_id =1;
```

2. **特定のチームに属する全てのタスクを取得するクエリを書いてください。**

```sql
SELECT * 
FROM  tasks 
WHERE team_id =1;
```

3. **全てのタスクとそれに対するコメントの数を取得するクエリを書いてください。**
```sql
SELECT tasks.*, COUNT(comments.task_id) AS comment_count
FROM tasks
LEFT JOIN comments ON tasks.id = comments.task_id
GROUP BY tasks.id;

```
4. **特定のユーザーがアサインされているタスクの詳細と、そのタスクのコメントを取得するクエリを書いてください。**

```sql
SELECT tasks.*,comments.* 
FROM tasks JOIN comments ON tasks.id  = comments.task_id 
WHERE tasks.assignee_id = 1;
```
5. **特定のユーザーがオーナーである全てのチームと、そのチームに所属しているメンバーの情報を取得するクエリを書いてください。**

```sql
SELECT teams.*,members.* 
FROM teams JOIN members ON teams.id = members.team_id 
WHERE teams.owner_id =1;
```