    <main class="page__main page__main--adding-post">
      <div class="page__main-section">
        <div class="container">
          <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
          <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
              <ul class="adding-post__tabs-list filters__list tabs__list">
              <?php foreach ($content_types as $type):?>
              <li class="adding-post__tabs-item filters__item">
                  <a class="adding-post__tabs-link filters__button filters__button--<?=$type['type'];?> <?php if ($ctype == $type['id']):?>filters__button--active<?php endif;?> tabs__item tabs__item--active button" href="add.php?ctype=<?=$type['id']?>">
                    <svg class="filters__icon" width="22" height="18">
                      <use xlink:href="#icon-filter-<?=$type['type'];?>"></use>
                    </svg>
                    <span><?=$type['name'];?></span>
                  </a>
                </li>
                <?php endforeach;?>
              </ul>
            </div>
            <div class="adding-post__tab-content">
            <?php if ($ctype === 3):?>
              <section class="adding-post__photo tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления фото</h2>
                <form class="adding-post__form form" action="add.php?ctype=<?=$ctype?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="photo-heading" type="text" name="header" placeholder="Введите заголовок" value="<?php if(!empty($data_post['header'])): echo $data_post['header']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['header']['header'])): echo $errors['header']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['header']['text'])): echo $errors['header']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                        <div class="form__input-section <?php if(!empty($errors['photo'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="photo-url" type="text" name="photo_link" placeholder="Введите ссылку" value="<?php if(!empty($data_post['filter_url'])): echo $data_post['filter_url']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['photo']['header'])): echo $errors['photo']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['photo']['text'])): echo $errors['photo']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="photo-tags" type="text" name="tags" placeholder="Введите теги" value="<?php if(!empty($data_post['tags'])): echo $data_post['tags']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if ($errors):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                            <li class="form__invalid-item"><strong><?php if(!empty($error)): echo $error['header'] . "</strong><BR>" . $error['text']; endif;?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif;?>
                  </div>
                  <div class="adding-post__input-file-container form__input-container form__input-container--file">
                    <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                      <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="uploadfile" title=" ">
                        <div class="form__file-zone-text">
                          <span>Перетащите фото сюда</span>
                        </div>
                      </div>
                      <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                        <span>Выбрать фото</span>
                        <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                          <use xlink:href="#icon-attach"></use>
                        </svg>
                      </button>
                    </div>
                    <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                    </div>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            <?php elseif ($ctype === 4):?>
              <section class="adding-post__video tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления видео</h2>
                <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="video-heading" type="text" name="header" placeholder="Введите заголовок" value="<?php if(!empty($data_post['header'])): echo $data_post['header']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['header']['header'])): echo $errors['header']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['header']['text'])): echo $errors['header']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['video_link'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="video-url" type="text" name="video_link" placeholder="Введите ссылку" value="<?php if(!empty($data_post['filter_url'])): echo $data_post['filter_url']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['video_link']['header'])): echo $errors['video_link']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['video_link']['text'])): echo $errors['video_link']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="video-tags" type="text" name="tags" placeholder="Введите теги" value="<?php if(!empty($data_post['tags'])): echo $data_post['tags']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if ($errors):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                            <li class="form__invalid-item"><strong><?php if(!empty($error)): echo $error['header'] . "</strong><BR>" . $error['text']; endif;?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif;?>
                  </div>

                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            <?php elseif ($ctype === 1):?>
              <section class="adding-post__text tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления текста</h2>
                <form class="adding-post__form form" action="add.php" method="post">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="text-heading" type="text" name="header" placeholder="Введите заголовок" value="<?php if(!empty($data_post['header'])): echo $data_post['header']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['header']['header'])): echo $errors['header']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['header']['text'])): echo $errors['header']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['post'])):?>form__input-section--error<?php endif;?>">
                          <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="post" placeholder="Введите текст публикации"><?php if(!empty($data_post['post'])): echo $data_post['post']; endif;?></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['post']['header'])): echo $errors['post']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['post']['text'])): echo $errors['post']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="post-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="post-tags" type="text" name="tags" placeholder="Введите теги" value="<?php if(!empty($data_post['tags'])): echo $data_post['tags']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if ($errors):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                            <li class="form__invalid-item"><strong><?php if(!empty($error)): echo $error['header'] . "</strong><BR>" . $error['text']; endif;?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif;?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            <?php elseif ($ctype === 2):?>
              <section class="adding-post__quote tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления цитаты</h2>
                <form class="adding-post__form form" action="add.php" method="post">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="quote-heading" type="text" name="header" placeholder="Введите заголовок" value="<?php if(!empty($data_post['header'])): echo $data_post['header']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['header']['header'])): echo $errors['header']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['header']['text'])): echo $errors['header']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['post'])):?>form__input-section--error<?php endif;?>">
                          <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="post" placeholder="Текст цитаты"><?php if(!empty($data_post['post'])): echo $data_post['post']; endif;?></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['post']['header'])): echo $errors['post']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['post']['text'])): echo $errors['post']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['author_quote'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="quote-author" type="text" name="author_quote" placeholder="Автор цитаты" value="<?php if(!empty($data_post['author_quote'])): echo $data_post['author_quote']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['author_quote']['header'])): echo $errors['author_quote']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['author_quote']['text'])): echo $errors['author_quote']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="cite-tags" type="text" name="tags" placeholder="Введите теги" value="<?php if(!empty($data_post['tags'])): echo $data_post['tags']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if ($errors):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                            <li class="form__invalid-item"><strong><?php if(!empty($error)): echo $error['header'] . "</strong><BR>" . $error['text']; endif;?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif;?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            <?php elseif ($ctype === 5):?>
              <section class="adding-post__link tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления ссылки</h2>
                <form class="adding-post__form form" action="add.php" method="post">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="link-heading" type="text" name="header" placeholder="Введите заголовок" value="<?php if(!empty($data_post['header'])): echo $data_post['header']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['header']['header'])): echo $errors['header']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['header']['text'])): echo $errors['header']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['site_link'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="post-link" type="text" name="site_link" placeholder="Введите ссылку" value="<?php if(!empty($data_post['filter_url'])): echo $data_post['filter_url']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?php if(!empty($errors['site_link']['header'])): echo $errors['site_link']['header']; endif;?></h3>
                            <p class="form__error-desc"><?php if(!empty($errors['site_link']['text'])): echo $errors['site_link']['text']; endif;?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="link-tags" type="text" name="tags" placeholder="Введите теги" value="<?php if(!empty($data_post['tags'])): echo $data_post['tags']; endif;?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if ($errors):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                            <li class="form__invalid-item"><strong><?php if(!empty($error)): echo $error['header'] . "</strong><BR>" . $error['text']; endif;?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif;?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            <?php endif;?>
            </div>
          </div>
        </div>
      </div>
    </main>
