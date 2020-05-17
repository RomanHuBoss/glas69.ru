<?php

$routesData = [
    //только гости
    'guest' => [
        '/user/register/form'                                           => ['methods' => ['GET']],   //форма регистрации
        '/user/register'                                                => ['methods' => ['POST']],  //регистрация
        '/user/login/form'                                              => ['methods' => ['GET']],   //форма авторизации
        '/user/login'                                                   => ['methods' => ['POST']],  //попытка залогиниться
        '/user/recover/form'                                            => ['methods' => ['GET']],   //форма ввода данных для восстановления пароля
        '/user/recover'                                                 => ['methods' => ['POST']],  //попытка запросить восстановление пароля
        '/user/reset/form'                                              => ['methods' => ['GET']],   //форма сброса пароля
        '/user/reset'                                                   => ['methods' => ['POST']],   //сброс пароля
    ],

    //любой пользователь, включая гостей
    'guest|user|operator|admin' => [
        ''                                                              => ['methods' => ['GET']] ,  //просмотр главной страницы
        '/common/main'                                                  => ['methods' => ['GET']] ,  //просмотр главной страницы
        '/common/terms'                                                 => ['methods' => ['GET']] ,  //условия работы
        '/common/statistics'                                            => ['methods' => ['GET']] ,  //просмотр страницы статистик
        '/common/feedback/form'                                         => ['methods' => ['GET']] ,  //форма обратной связи
        '/common/feedback/send'                                         => ['methods' => ['POST']] , //отправка email через форму обратной связи
        '/common/fias/search'                                           => ['methods' => ['GET']] , //поиск ФИАС-адресов
        '/user/search'                                                  => ['methods' => ['POST']] , //поиск пользователя
        '/user/list'                                                    => ['methods' => ['GET']] ,  //страница со списком пользователей
        '/user/list/page/{page}'                                        => ['methods' => ['GET']] ,  //страница со списком пользователей
        '/user/profile/{userId}'                                        => ['methods' => ['GET']] ,  //просмотр чьего-либо профиля
        '/referendum/search'                                            => ['methods' => ['GET', 'POST']] , //поиск референдума
        '/referendum/list'                                              => ['methods' => ['GET']] ,  //список референдумов
        '/referendum/list/page/{page}'                                  => ['methods' => ['GET']] ,  //список референдумов
        '/referendum/show/{referendumId}'                               => ['methods' => ['GET']] ,  //просмотр референдума
        '/referendum/{referendumId}/message/list'                       => ['methods' => ['GET']] ,  //просмотр сообщений в форуме референдума
        '/referendum/{referendumId}/message/list/page/{page}'           => ['methods' => ['GET']] ,  //просмотр сообщений в форуме референдума
        '/referendum/{referendumId}/message/show/{messageId}'           => ['methods' => ['GET']] ,  //просмотр сообщения в форуме референдума
        '/appeal/search'                                                => ['methods' => ['GET', 'POST']] , //поиск обращений
        '/appeal/list'                                                  => ['methods' => ['GET']] ,  //список обращений
        '/appeal/list/page/{page}'                                      => ['methods' => ['GET']] ,  //список обращений
        '/appeal/show/{appealId}'                                       => ['methods' => ['GET']] ,  //просмотр обращения
        '/appeal/{appealId}/message/list'                               => ['methods' => ['GET']] ,  //просмотр сообщений в форуме обращения
        '/appeal/{appealId}/message/list/page/{page}'                   => ['methods' => ['GET']] ,  //просмотр сообщений в форуме обращения
        '/appeal/{appealId}/message/show/{messageId}'                   => ['methods' => ['GET']] ,  //просмотр сообщения в форуме обращения
    ],

    //для авторизованных
    'user|operator|admin' => [
        '/user/logout'                                                  => ['methods' => ['GET']] ,  //выход из системы
        '/user/cabinet/appeals'                                         => ['methods' => ['GET']] ,  //мои обращения
        '/user/cabinet/contact'                                         => ['methods' => ['GET']] ,  //контакты
        '/user/settings/form'                                           => ['methods' => ['GET']] ,  //настройки
        '/user/settings'                                                => ['methods' => ['POST']] ,  //обновить настройки
        '/mail/receiver/search'                                         => ['methods' => ['GET']],  // поиск получателей почты
        '/mail/inbox'                                                   => ['methods' => ['GET']] ,  //раздел входящих сообщений
        '/mail/inbox/page/{page}'                                       => ['methods' => ['GET']] ,  //раздел входящих сообщений
        '/mail/outbox'                                                  => ['methods' => ['GET']] ,  //раздел исходящих сообщений
        '/mail/outbox/page/{page}'                                      => ['methods' => ['GET']] ,  //раздел исходящих сообщений
        '/mail/count'                                                   => ['methods' => ['POST']] , //счет новых, общего числа входящих и исходящих сообщений
        '/mail/send/form'                                               => ['methods' => ['GET']] ,  //форма отправки почты
        '/mail/send'                                                    => ['methods' => ['POST']] , //отправка почты
        '/mail/show/{messageId}'                                        => ['methods' => ['GET']] ,  //чтение письма
        '/mail/delete/{messageId}'                                      => ['methods' => ['POST']] ,  //удаление письма из входящих или исходящих
        '/referendum/{referendumId}/message/form'                       => ['methods' => ['GET']] ,   //форма создания сообщения к референдуму
        '/referendum/{referendumId}/message/send'                       => ['methods' => ['POST']] ,   //отправки сообщения к референдуму
        '/appeal/{appealId}/message/form'                               => ['methods' => ['GET']] ,   //форма создания сообщения к референдуму
        '/appeal/{appealId}/message/send'                               => ['methods' => ['POST']] ,   //отправки сообщения к референдуму

    ],

    //пользователь
    'user' => [
        '/appeal/form'                                                  => ['methods' => ['GET']] ,   //форма создания обращения
        '/appeal/create'                                                => ['methods' => ['POST']] ,  //создание обращения
    ],

    //оператор
    'operator' => [
        '/user/kick/{userId}'                                           => ['methods' => ['POST']] ,   //заблокировать пользователя
        '/user/ban/{userId}'                                            => ['methods' => ['POST']] ,   //забанить пользователя
        '/referendum/form'                                              => ['methods' => ['GET']] ,   //форма создания референдума
        '/referendum/create'                                            => ['methods' => ['POST']] ,  //создание референдума
        '/referendum/update/{referendumId}'                             => ['methods' => ['POST']] ,  //обновление данных референдума
        '/referendum/delete/{referendumId}'                             => ['methods' => ['POST']] ,   //удаление референдума
        '/referendum/{referendumId}/message/apply/{messageId}'          => ['methods' => ['POST']] ,  //одобрить сообщение в форуме референдума
        '/referendum/{referendumId}/message/decline/{messageId}'        => ['methods' => ['POST']] ,  //отклонить сообщение в форуме референдума
        '/appeal/{appealId}/message/apply/{messageId}'                  => ['methods' => ['POST']] ,  //одобрить сообщение в форуме обращения
        '/appeal/{appealId}/message/decline/{messageId}'                => ['methods' => ['POST']] ,  //отклонить сообщение в форуме обращения
    ],

    //админ
    'admin' => [

    ],
];
