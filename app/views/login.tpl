{extends file="common/layout.tpl"}

{block name="content"}
    <form method="post">
        <input type="text"
            name="username"
            placeholder="Потребителско име"
            value="{$old_username|default:''}"
            required>

        <input type="password"
            name="password"
            placeholder="Парола"
            required>

        <button type="submit">Вход</button>
    </form>
{/block}