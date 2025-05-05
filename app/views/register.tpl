{extends file="layout.tpl"}

{block name="content"}
    <form method="post">
        <input type="text" name="username" placeholder="Потребителско име" required>
        <input type="password" name="password" placeholder="Парола" required>
        <button type="submit">Регистрация</button>
    </form>
{/block}