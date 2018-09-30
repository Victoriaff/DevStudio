<?php
//global $wp_actions;
//dump( $wp_actions );

//dump( $data );
?>

<table class="data-table" cellspacing="1">
    <?php if (!empty($data['headers'])) { ?>
        <thead>
            <?php foreach($data['headers'] as $header) echo '<th>'.$header.'</th>'; ?>
        </thead>
    <?php } ?>
    <tbody>
    <?php
    foreach($data['rows'] as $key=>$row) {
	    if ( isset( $row['type'] ) && $row['type'] == 'subheader' ) { ?>
            <tr class="subheader">
                <td colspan="10"><?php echo $row['value']; ?></td>
            </tr>
	    <?php } else { ?>
            <tr<?php echo isset($row['class']) ? ' class="'.esc_attr($row['class']).'"':''; ?><?php echo isset($row['id']) ? ' id="'.esc_attr($row['id']).'"':''; ?>>
			    <?php foreach ( $row['columns'] as $col ) { ?>
                    <td class="<?php echo ! empty( $col['class'] ) ? esc_attr( $col['class'] ) : ''; ?>"><?php echo wp_kses_post( $col['value'] ); ?></td>
			    <?php } ?>
            </tr>
	    <?php }
    }
    ?>
    </tbody>
</table>
