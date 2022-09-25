<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center>
		*********************************
		<?php 
			if (!empty($getAllOptions['header_caisse'])) {
				echo "<br>" ;
				$exploded = explode("\r\n",$getAllOptions['header_caisse']) ;

				$res = "" ;

				foreach ($exploded as $item) {
					$res .= "<span>".$item."</span>" ;
					$res .= "<br>" ;
				}

				echo $res;

				echo "*********************************" ;
			}
		?>
		<br>
		<span>Ticket de caisse : <?php echo $all['facture']['facture_numero']?></span>
		<br>
		*********************************
		<br>
		<table>
			<tr>
				<td>Désignation</td>
				<td>Quantité</td>
				<td>Sous-Total</td>
			</tr>
			<?php
				$total = 0;
				foreach ($all['details'] as $data) {
				$total = $total + ($data['prix_article']*$data['vente_quantite']);
			?>
				<tr>
					<td><?= $data['nom_article']; ?></td>
					<td style='text-align: center'><?= $data['vente_quantite']; ?></td>
					<td>
						<?php 
							$tt = $data['prix_article']*$data['vente_quantite']; 
							echo "Ar ".number_format($tt,0,',','.'); ?>
					</td>
				</tr>
			<?php
				}
			?>
		</table>
		<br>
		********************************
		<br>
		<span style="font-weight:bold">MODE DE PAIEMENT : <?php echo $all['facture']['mode_paiement'] ?></span>
		<br>
		<span style="font-weight:bold">TOTAL : Ar <?php echo number_format($total,0,',','.')?></span>
		<br>
		<?php 
			if ($all['facture']['id_mode_paiement'] != 1) { ?>
				<span style="font-weight:bold">REFERENCE : <?php echo $all['facture']['rr'] ?></span>
		<?php	}
		else { ?>
				<span style="font-weight:bold">PAYER : Ar <?php echo number_format($all['facture']['montant_recu'],0,',','.')  ?></span>
				<br>
				<span style="font-weight:bold">RESTE : Ar <?php echo number_format($all['facture']['rr'],0,',','.') ?></span>
		<?php }
		?>

		<br>

		<?php if (!empty($getAllOptions['footer_caisse'])): ?>
			********************************
			<br>
			<span><?php echo $getAllOptions['footer_caisse'] ?></span>
			<br>
		<?php endif ?>

	</center>
</body>
</html>