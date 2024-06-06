# Lv. 2

1. **全てのタスクとそれに対応するチーム名を取得するクエリを書いてください。**
```sql
SELECT tasks.*, teams.name  
FROM tasks JOIN teams  ON tasks.team_id  = teams.id; 
```
```php
Task::with('team:id,name')->get();
```
2. **特定のユーザーがアサインされているタスクを取得するクエリを書いてください。**
```sql
SELECT * 
FROM tasks 
WHERE assignee_id =1;
```
```php
Task::where('assignee_id','1')->get()
```
3. **特定のチームに所属している全てのメンバーの情報を取得するクエリを書いてください。**
```sql
SELECT * 
FROM members 
WHERE team_id =1;
```
```php
Member::where('team_id','1')->get()
```
4. **特定のユーザーが作成したチームの情報を取得するクエリを書いてください。**
```sql
SELECT * 
FROM teams 
WHERE owner_id =1;
```
```php
Team::where('owner_id','=','1')->get();
```
5. **特定のタスクのステータスを更新するクエリを書いてください。**
```sql
UPDATE tasks 
SET status =1 
WHERE id =1;
```
```php
Task::where('id', 1)->update(['status' => 1]);
```







