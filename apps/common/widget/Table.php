<?php

class Table {

    public static function active($data = null)
    {
        #start function
        if(!$data) return false; ?>
        <table style="width: 100%" border="1" cellspacing="1" cellpadding="3"  bgcolor="#999999">
            <thead>
                <tr>
                    <?php foreach($data['title'] as $td): ?>
                        <td><?php echo $td ?></td>
                    <?php endforeach; ?>
                        <td>Thao tác</td>
                </tr>
            </thead>
            <tbody>
                <?php if(count($data['source']->items)): ?>
                <?php foreach($data['source']->items as $item): ?>
                <tr>
                    <?php foreach ($data['col'] as $col): ?>
                    <td>
                        <?php
                            if($col === 'status'){
                                echo (int)$item->$col === 1 ? '<span style="color: green">Hiển thị</span>' : '<span style="color: red">Đang ẩn</span>';
                            }else{
                                echo $item->$col;
                            }
                        ?>
                    </td>
                    <?php endforeach; ?>
                    <td width="120px">
                        <a class="request" href="<?php echo $data['link'][0].$item->id ?>">Chỉnh sửa</a> &nbsp;|&nbsp;
                        <?php if(isset($item->role) && (int)$item->role === 1): ?>
                            <span>Xóa</span>
                        <?php else: ?>
                            <script>
                            var _0x6ee6=["\x42\u1EA1\x6E\x20\x63\xF3\x20\x6D\x75\u1ED1\x6E\x20\x78\xF3\x61\x20\x64\u1EEF\x20\x6C\x69\u1EC7\x75\x20\x6E\xE0\x79\x3F","\x73\x75\x62\x6D\x69\x74","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64"];function deleteRow(_0x3396x2){var _0x3396x3=confirm(_0x6ee6[0]);if(_0x3396x3){document[_0x6ee6[2]](_0x3396x2)[_0x6ee6[1]]()}}
                            </script>
                            <form style="display: none" id="<?php echo $item->id ?>" action="<?php echo $data['link'][1] ?>" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                            </form>
                            <a href="javascript:void(0)" onclick="deleteRow('<?php echo $item->id ?>')">Xóa</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="<?php echo count($data['col'])+1 ?>" align="center">Không có đữ liệu</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- start paging -->
        <center>
        <?php if($data['source']->total_pages > 1): ?>
        <ul class="pagination">
            <?php if($data['source']->current > 1): ?>
            <li>
                <a class="request" href="<?php echo $data['link'][2].$data['source']->before ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php endif; ?>
            <!-- number here -->
            <?php for ($i=1; $i <= $data['source']->total_pages; $i++): ?>
                <?php if((int)$data['source']->current === $i): ?>
                    <li class="active"><a><?php echo $i ?></a></li>
                <?php else: ?>
                    <li><a class="request" href="<?php echo $data['link'][2].$i ?>"><?php echo $i ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <!-- /number here -->
            <?php if($data['source']->current < $data['source']->total_pages): ?>
            <li>
                <a class="request" href="<?php echo $data['link'][2].$data['source']->next ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
        </center>
        <!-- end paging -->
<?php } #end function
}