Главная админка: localhost/project/NewClientAdmin.php?admin_key=ed2f1a7b93c4d8e7a6b1d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b484359345934958349583498593485934853948593485934859gjdfgd;kfjgd;fkjg34534645645645644





Доступ к admin, NewClientAdmin, user
localhost/project/admin.php?key=ed2f1a7b93c4d8e7a6b1d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b484359345934958349583498593485934853948593485934859gjdfgd;kfjgd;fkjg34534645645645644
localhost/project/NewClientAdmin.php?admin_key=ed2f1a7b93c4d8e7a6b1d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b484359345934958349583498593485934853948593485934859gjdfgd;kfjgd;fkjg34534645645645644
localhost/project/user.php?key=ed2f1a7b93c4d8e7a6b1d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b4a9c6d5f2c8e3d4b9a7c8e2d3b484359345934958349583498593485934853948593485934859gjdfgd;kfjgd;fkjg34534645645645644

Примеры запросов для items
Получение первых 10 записей:
localhost/project/items.php?page=0&count=10
Поиск по имени "Тест":
localhost/project/items.php?search=Тест
Фильтрация по статусу "InProgress":
localhost/project/items.php?field=status&filter=InProgress
Комбинированный поиск и фильтрация:
localhost/project/items.php?search=Тест&field=status&filter=InProgress
Получение следующих 10 записей:
localhost/project/items.php?page=1&count=10
Поиск по имени "Егор":
localhost/project/items.php?search=Егор
Фильтрация по имени "Тестовый":
localhost/project/items.php?field=name&filter=Тестовый
Комбинированный поиск и фильтрация с новыми данными:
localhost/project/items.php?search=Тестовый&field=status&filter=InProgress

Для запросов сущностей:
Поиск - localhost/project/item.php?item=users&id=1&operation=search
Вставка - localhost/project/item.php?item=users&operation=insert&data={"login": "user1", "first_name": "John", "last_name": "Doe", "middle_name": "M", "email": "user1@example.com", "password": "hashed_password", "session_id": "abc123"}
Обновление - localhost/project/item.php?item=users&id=1&operation=update&data={"login": "UpdatedLogin", "first_name": "UpdatedFirstName", "last_name": "UpdatedLastName", "middle_name": "UpdatedMiddleName", "email": "updated@example.com", "password": "new_hashed_password", "session_id": "new_session_id"}
Удаление - localhost/project/issue.php?entity=issues&id=1

Для страниц чаты:
удаление - localhost/project/chat/delete.php?id_messages=6&sender_id=1
отправление - localhost/project/chat/send.php?contactId=1&senderID=1&message=Привет, я рома
обновление - localhost/project/chat/update.php?id_messages=1&sender_id=2&new_message=Приветик!