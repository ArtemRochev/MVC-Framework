-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: book
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `content` text,
  `img_preview_url` varchar(500) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (2,1,'Псевдостриминг mp4 в nginx с каналом 7Gbit/s','Предыстория:\r\nЕсть площадка с видео контентом, где посещаемость около 500 тысяч уников в сутки. Видео у себя не хранили, а любезно заимствовали с сайтов «партнеров». Ну как заимствовали: в реальном времени парсили с сайта ссылки на видеопотоки и вставляли в свой плеер.\r\n\r\nВ такой схеме было несколько ключевых проблем: \r\nНужно поддерживать работоспособность парсеров в режиме 24/7 для всех сайтов партнеров, а их не один десяток;\r\nВидео иногда удаляются;\r\nПосле определённой нагрузки, а иногда спонтанно, некоторые видео начинают требовать ретрансляции.\r\n\r\nВ определённый момент поняли, что так жить больше нельзя и нужно раздавать видео со своих серверов. По примерной оценке размер видео был 4-5TB и максимальный порт в час пик около 5-7Gbit/s (после запуска цифры оказались примерно такими же).\r\n\r\nКратко о структуре\r\n\r\nГлавный сервер: \r\nХранит все видео;\r\nОтвечает за загрузку видео с сайта партнера;\r\nРаспределяет видео по раздающим серверам;\r\nСчитает статистику популярности видео;\r\nОтдает плей-листы для плеера;\r\nЯвляется балансировщиком для выбора раздающего сервера;\r\n\r\nРаздающий сервер: \r\nРаздает видео.\r\n\r\nВидео — это все качества (240, 360, 480 и 720) одного видео + фото заставки. Все видео конвертируем в mp4 (H.264 видео и AAC аудио), фото заставки в jpeg.\r\n\r\nВсе сервера имеют две сетевые карты, каждая с портом 1Gbit/s. Внешняя сетевая карта для раздачи, а внутренняя для распределения видео с главного на раздающие сервера.\r\n\r\nГлавный сервер один, а раздающих может быть любое количество. Раздающие сервера объедены в группы и один сервер может принадлежать только одной группе. Видео может входить только в одну группу. При запросе видео, балансировка идет только между серверами группы, к которой принадлежит запрашиваемое видео.\r\n\r\nБэкенд реализован на yii2.\r\n\r\nЗагрузка нового видео\r\n\r\nНа главный сервер прилетает запрос по API с ссылкой на видео, которое нужно скачать. Если видео поддается парсингу, то оно добавляется в стек на скачивание. После скачивания оно попадает в стек для распределения на раздающие сервера. Перед загрузкой на раздающий сервер для видео выбирается группа (выбирается один раз и больше не меняется).\r\n\r\nНа данный момент, группа выбирается банальным образом. Идет равномерное распределение по количеству видео. Так как размер видео разный, то если группа заполнена под завязку то она выпадает из дальнейшего распределения.\r\n\r\nПосле скачивания видео оно конвертируется в mp4 (H.264 видео и AAC аудио) с помощью ffmpeg. Чтобы видео быстро стартовало в плеере его нужно прогнать через MP4Box. Это необходимо из-за того, что ffmpeg помещает “moov-атомы” (мета-информацию о видео) в конец файла, однако, чтобы пользователь имел возможность просматривать видео не дожидаясь его полной загрузки, эти атомы должны быть вначале файла.\r\n\r\nСкачивание файлов на главный сервер и их распределение по раздающим серверам работает в несколько потоков. При этом видео скачивается параллельно во всех качествах.\r\n\r\nДля многопоточности использую стек для заданий (FIFO) + демон, который поддерживает нужное количество потоков. Поток – это запущенный демоном php через exec. Все добро сделал велосипедом компонентом для yii2. Если будет интересно, то оформлю в рамках отдельной статьи.\r\n\r\nКак только, хотябы одно качество, видео загрузится на все раздающие сервера в своей группе оно становится доступным для стриминга.\r\n\r\nХранение видео\r\n\r\nРассмотрим хранения файлов на примере видео с id = 3044: \r\nvideoHash – это md5(id) \r\nvideoHashChar2 – первые два символа от videoHash \r\nquality – качество видео (240, 360, 480, 720) \r\n\r\nstorage/image/<b>{videoHashChar2}</b>/<b>{videoHash}</b>.jpg  \r\nstorage/video/<b>{videoHashChar2}</b>/<b>{videoHash}</b>.<b>{quality}</b>.mp4  \r\n \r\nmd5(3044) = b8af7d0fbf094517781e0382102d7b27 \r\nstorage/image/b8/b8af7d0fbf094517781e0382102d7b27.jpg \r\nstorage/video/b8/b8af7d0fbf094517781e0382102d7b27.240.mp4 \r\n… \r\nstorage/video/b8/b8af7d0fbf094517781e0382102d7b27.720.mp4\r\n','https://snap-photos.s3.amazonaws.com/img-thumbs/960w/C8K19BYLLW.jpg','2015-09-01 20:49:33'),(4,1,'Тюним память и сетевой стек в Linux: история перевода высоконагруженных серверов на свежий дистрибутив','До недавнего времени в Одноклассниках в качестве основного Linux-дистрибутива использовался частично обновлённый OpenSuSE 10.2. Однако, поддерживать его становилось всё труднее, поэтому с прошлого года мы перешли к активной миграции на CentOS 7. На подготовительном этапе перехода для CentOS были отработаны все внутренние процедуры, подготовлены конфиги и политики настройки (мы используем CFEngine). Поэтому сейчас во многих случаях миграция с одного дистрибутива на другой заключается в установке ОС через kickstart и развёртывании приложения с помощью системы деплоя нашей разработки — всё остальное осуществляется без участия человека. Так происходит во многих случаях, хотя и не во всех.\r\n\r\nНо с самыми большими проблемами мы столкнулись при миграции серверов раздачи видео. На их решение у нас ушло полгода.\r\n\r\n\r\nВкратце об их конфигурации:\r\n4 x 10 Гбит к пользователям\r\n2 x 10 Гбит к хранилищу\r\n256 Гбайт RAM — кэш в памяти\r\n22 х 480 Гбайт SSD — кэша на SSD\r\n2 х E5-2690 v2\r\n\r\n\r\nНесколько метрик, характеризующих раздачу видео:\r\n600 Гбит/сек. — общая пиковая скорость отдачи видео\r\n220М просмотров видео в день\r\n600К одновременно просматриваемых видео\r\n\r\n\r\nПроблема 1 — сильный рост CPU system time\r\n\r\nimage\r\n\r\nВскоре после запуска первого сервера начала сильно расти нагрузка на процессор по system time.\r\nВ это же время в top было видно множество migration и ksoftirqd процесов. Сначала мы попробовали крутить настройки ядра. Что нам не помогло:\r\nувеличение sched_migration_cost\r\nотключение transparent_hugepage\r\nувеличение vfs_cache_pressure\r\nотключение NUMA\r\n\r\nПри очередном росте нагрузки perf top показал 50% нагрузки на isolate_freepages_block. Само по себе название вызова нам, к сожалению, ничего не говорит. Но вот слово freepages несколько смутило, т.к. свободной памяти на сервере было около 45 Гбайт. Из своего опыта мы уже знали, что если на сервере много свободной памяти, а ядро всё равно жалуется на его нехватку (иногда это выражается в запуске OOM killer), то, скорее всего, проблема во фрагментации. Сброс дискового кеша (echo 3 > /proc/sys/vm/drop_caches) моментально исцелял сервер, что только подтверждало наши предположения.\r\n\r\nФрагментация памяти — нередкая проблема (и характерна не только для Linux), и в ядро регулярно вносятся изменения для борьбы с ней. Одним из виновников фрагментации является само ядро, точнее дисковый кеш, который нельзя ни отключить, ни ограничить в объёме. Это не значит, что фрагментация в нашем случае была вызвана именно дисковым кешем, но точные причины были не так важны. Важнее было решение — дефрагментация. Такой механизм есть в ядре, но очевидно, что он не справлялся (либо вместо него запускалось высвобождение памяти — global reclaim). Дефрагментация запускается только тогда, когда свободная память опускается ниже определённой отметки (zone watermark), и в нашем случае это происходило слишком поздно. Единственный способ заставить её запускаться раньше — это повысить min_free_kbytes через sysctl. Данный параметр говорит ядру стараться держать часть памяти свободной, а чтобы удовлетворить это требование, ему приходится запускать дефрагментацию раньше. В нашем случае хватило значения в 1 Гбайт.\r\n\r\nПроблема 2 — уход в swap\r\n\r\nДля начала стоит упомянуть, что мы используем vm.swappiness=0, так как точно знаем, что для нас своп — это зло.\r\nИтак, на сервере около 45 Гбайт свободной памяти и всё же он периодически уходит в своп. Как такое возможно?\r\nДля начала стоит напомнить, что память в Linux — это не один большой кусок.\r\nПамять делится на ноды: один физический процессор — одна нода.\r\nКаждая нода делится на зоны (представление для 64-битных систем) — ZONE_DMA (0-16 Мбайт), ZONE_DMA32 (0-4 Гбайт), ZONE_NORMAL (4+ Гбайт).\r\nКаждая зона делится на области памяти размером степеней двойки (order of 2), т.е. 20*PAGE_SIZE, 21*PAGE_SIZE...210*PAGE_SIZE (текущее распределение можно посмотреть в /proc/buddyinfo). Отсутствие свободных областей большого размера — это и есть фрагментация, о которой мы говорили в предыдущем разделе.\r\n\r\n\r\nСначала мы опять винили фрагментацию, но дальнейшее увеличение min_free_kbytes, а также увеличение vfs_cache_pressure нам не помогло. Пришлось познакомиться с утилитой numastat (numastat -m < PID >).\r\nНо сначала ещё одно отступление про работу приложения раздачи видео. На сервере замонтирован tmpfs (занимает почти всю память), на котором приложение создаёт 1 файл и использует его в качестве кеша.','https://habrastorage.org/getpro/habr/post_images/ff4/f8a/000/ff4f8a000a92a27f8f91112bd1d0c7cc.jpg','2015-09-03 22:07:22');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `text` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,2,'Комментарий 1','2015-09-03 21:27:50'),(2,1,2,'dd','2015-09-03 21:42:56'),(7,1,2,'f','2015-09-06 08:59:38'),(8,1,2,'gdfdg','2015-09-06 09:02:01'),(9,1,2,'pp','2015-09-06 09:49:59'),(10,1,2,'qq','2015-09-06 09:51:13'),(11,1,2,'ee','2015-09-06 09:51:46');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Artem','artem@ukr.net','123','VV0ARMhGF8NClVhxS2cfRTjDJF9jFo',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-10 23:59:18
