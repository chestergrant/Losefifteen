<div class="contact-card-panel">
    <div class="contact-name"><?php echo htmlspecialchars($contact[$i]["firstname"])." ".htmlspecialchars($contact[$i]["lastname"]); ?></div>
    <div class="contact-main">
        <table>
            <tr>
                <td>Skype ID:</td>
                <td><?php echo htmlspecialchars($contact[$i]["skype"]);?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo htmlspecialchars($contact[$i]["email"]);?></td>
            </tr>
        </table>
    </div>
</div>    
