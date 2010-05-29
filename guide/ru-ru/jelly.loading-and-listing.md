# Загрузка и получение данных

Jelly расширяет Query Builder Database модуля Kohana. Так как Jelly известно всё о модели,
он добавляет некоторые дополнительные поля и алиасы модели и автоматически подгружает
отношения 1:1.

Это является более объекто-ориентированным подходом в построении запросов, при котором, по большей
части, запрашиваются Jelly объекты из модели, нежели строки из таблицы базы данных.

### Поиск одной записи

В основном вся работа строится вокруг одной записи, но перед тем, как с ней работать, нужно её
сначала найти!

##### Пример: загрузка одной записи

	$post = Jelly::select('post', 1);
	$post->loaded(); // Возвращает TRUE
	$post->saved(); // Возвращает TRUE
	
	// Предыдущий пример - это сокращённый вариант следующей записи
	$post = Jelly::select('post')->load(1);
	
	// А всё выше - сокращение следующего
	$post = Jelly::select('post')
				 ->where(':primary_key', '=', 1)
				 ->limit(1)
				 ->execute();
				 
### Поиск множеста записей

Для того, чтобы загрузить множество записей БД, необходмо завершить свой запрос методом `execute()`
который возвратит объект класса `Jelly_Collection`. `Jelly_Collection` содержит  набор записей,
которые представляют собой объекты модели, с которыми можно работать при итерировании этого массива.

[!!] **Заметка**: `Jelly_Collection` обладает тем же API, что и `Database_Result`, за исключением
того, что он возвращает модели Jelly.

##### Пример: поиск множеста записей

	// Поиск всех постов
	$posts = Jelly::select('post')->execute();

	foreach ($posts as $post)
	{
		echo $post->name;
	}

[!!] **Заметка**: Если при построении запроса использовать ограничение `limit()` равное 1, то
`execute()` вместо `Jelly_Collection` вернёт экземпляр модели напрямую.

##### *Так в чём же разница между `load()` и `execute()`*

Между методами `load()` и `execute()` небольшая, но существенная разница. `load()` неявно
ограничивает запрос до 1 записи и напрямую возвращает объект модели. `load()` так же может
опционально принимать `unique_key`, чтобы найти конкретную запись.

    // load() в основном - это сокращение следующей записи
    Jelly::select('post')->where(':unique_key', '=', $value)->limit(1)->execute();
    
В дополнение, `load()` полезен только в случаев запросов `SELECT`. Для других типов запросов этот
метод будет не эффективен.

### Подсчёт записей

В любой момент, при построении цепочки запроса, можно вызвать метод `count()`, чтобы выяснить,
сколько будет возвращено записей.

	$total_posts = Jelly::select('post')->where('published', '=', 1)->count();

### Query Builder

Если Вам знаком query builder Kohana, то Вы уже знаете, как использовать query builder в Jelly.

	// Поиск всех активных постов
	$posts = Jelly::select('post')->where('published', '=', 1)->execute();

	// Загрузка постов и их авторов в один запрос
	// Это возможно только для отношений 1:1, когда один пост имеет только одного автора
	$posts = Jelly::select('post')->with('author')->execute();

[!!] **Заметка**: Изучите раздел [расширение query builder'а](jelly.extending-builder) для изучения
более продвинутых опций для построения запросов.

### Далее [Создание, обновление и удаление данных](jelly.cud)
