# Lv. 1

1. **全てのユーザーを取得するクエリを書いてください。**
```sql
SELECT * 
FROM users;
```

```php
User::all();
```
2. **特定のチーム（例えばid:1が指定されたとしてハードコーディングで良いです。そのほかの場合も同様です）の詳細を取得するクエリを書いてください。**
```sql
SELECT * 
FROM teams 
WHERE id = 1;
```
```php
Team::find(1);
```
3. **ユーザーの名前とメールアドレスを取得するクエリを書いてください。**
```sql
SELECT name,email  
FROM users;
```
```php
User::select('name','email')->get();
```
4. **特定のユーザーのチームを取得するクエリを書いてください。**
```sql
SELECT * 
FROM teams  JOIN members ON teams.id  = members.team_id  
WHERE members.user_id =1;
```
```php
User::find(1)->joinedTeams;
```
5. **特定のタスクに対する全てのコメントを取得するクエリを書いてください。**
```sql
SELECT * 
FROM comments  
WHERE task_id =1;
```
```php
Task::find(1)->comments;
```






