# Lv. 4

1. **特定のチームにおける全てのタスクと、それに対するコメントの数を取得するクエリを書いてください。**
```sql
SELECT tasks.*, COUNT(comments.task_id) AS comment_count
FROM tasks
LEFT JOIN comments ON tasks.id = comments.task_id
WHERE tasks.team_id = 1
GROUP BY tasks.id; 
```
```php
Task::where('team_id', 1)->withCount('comments')->get();
```
2. **特定のユーザーがアサインされているタスクのタイトルと、各タスクに対するコメントの内容を取得するクエリを書いてください。**
```sql
SELECT tasks.title, comments.* 
FROM tasks JOIN comments  ON tasks.id = comments.task_id 
WHERE tasks.assignee_id =3;
```
```php
Task::where('assignee_id', 1)->with('comments')->get();
```
3. **特定のタスクに対する全てのコメントの詳細と、そのコメントを書いたユーザーの名前を取得するクエリを書いてください。**

```sql
SELECT comments.* ,users.name 
FROM comments JOIN users ON comments.author_id  = users.id 
WHERE comments.task_id = 12;
```
```php
Comment::where('task_id',12)->with('author:id,name')->get();
```
4. **特定のユーザーがアサインされているタスクの数を取得するクエリを書いてください。**
```sql
SELECT COUNT(tasks.id) 
FROM tasks 
WHERE tasks.assignee_id = 1;
```
```php
Task::where('assignee_id','3')->count();
```
5. **全てのチームと、そのチームに所属しているメンバーの数を取得するクエリを書いてください。**
```sql
SELECT teams.*,COUNT(members.id)  
FROM teams JOIN members 
ON teams.id = members.team_id 
GROUP BY teams.id;
```
```php
Team::withCount('members')->get();
```


