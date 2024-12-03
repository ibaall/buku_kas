    <!-- <div class="report" style="display:flex;width: 82%; margin-left: 165px; text-align:center; margin-top:30px">
      <div class="debt" style="margin-right:83px; width:50%; max-height: 120px; overflow-y:scroll; background-color: white;box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5)">
      <h3 style="text-align:center; padding: 10px">Debt Report</h3>
      <table border="1px">
        <tr>
            <th>Debtor Name</th>
            <th>Information</th>
            <th>Amount</th>
            <th>Debt Date</th>
            <th>Due Date</th>
        </tr>
        <?php
        // Tampilkan data dari tabel debt
        while ($row = $resultdebt->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["debtor_name"] . "</td>";
            echo "<td>" . $row["title_debt"] . "</td>";
            echo "<td>" . $row["amount_debt"] . "</td>";
            echo "<td>" . $row["debt_date"] . "</td>";
            echo "<td>" . $row["debt_due_date"] . "</td>";
            echo "</tr>";
        }
        ?>
            </table>
      </div>
      <div class="tax" style=" width:50% ; max-height: 120px; overflow-y:scroll; background-color: white;box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);">
      <h3 style="text-align:center;padding:10px">Tax Report</h3>
      <table border="1px" >
    <tr>
        <th>Title</th>
        <th>Notes</th>
        <th>Budget Date</th>
    </tr>
    <?php
        // Tampilkan data dari tabel debt
        while ($row = $resulttax->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["tax_total"] . "</td>";
            echo "<td>" . $row["due_date_tax"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
      </div>
    </div> -->