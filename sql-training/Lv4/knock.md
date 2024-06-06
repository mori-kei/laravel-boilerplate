# Lv. 4

1. **特定のチームにおける全てのタスクと、それに対するコメントの数を取得するクエリを書いてください。**
```sql
SELECT tasks.*, COUNT(comments.task_id) AS comment_count
FROM tasks
LEFT JOIN comments ON tasks.id = comments.task_id
WHERE tasks.team_id = 1
GROUP BY tasks.id; 
```

2. **特定のユーザーがアサインされているタスクのタイトルと、各タスクに対するコメントの内容を取得するクエリを書いてください。**
```sql
SELECT tasks.title, comments.* 
FROM tasks JOIN comments  ON tasks.id = comments.task_id 
WHERE tasks.assignee_id =3;
```

3. **特定のタスクに対する全てのコメントの詳細と、そのコメントを書いたユーザーの名前を取得するクエリを書いてください。**

```sql
SELECT comments.* ,users.name 
FROM comments JOIN users ON comments.author_id  = users.id 
WHERE comments.task_id = 12;
```

4. **特定のユーザーがアサインされているタスクの数を取得するクエリを書いてください。**
```sql
SELECT COUNT(tasks.id) 
FROM tasks 
WHERE tasks.assignee_id = 1;
```

5. **全てのチームと、そのチームに所属しているメンバーの数を取得するクエリを書いてください。**
```sql
SELECT teams.*,members.* 
FROM teams JOIN members 
ON teams.id = members.team_id;
```



