<div class="post__main">
  <div class="post-link__wrapper">
    <a class="post-link__external" href="http://<?=strip_tags($post['site_link']);?>" title="Перейти по ссылке">
      <div class="post-link__info-wrapper">
        <div class="post-link__icon-wrapper">
          <img src="https://www.google.com/s2/favicons?domain=<?=strip_tags($post['site_link']);?>" alt="Иконка">
        </div>
        <div class="post-link__info">
          <h3><?=htmlspecialchars($post['header']);?></h3>
        </div>
      </div>
    </a>
  </div>
</div>
