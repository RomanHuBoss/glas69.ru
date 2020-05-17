<?

namespace Glas\Models;

interface IUpdateable {
    function update($id, Array $data);
}