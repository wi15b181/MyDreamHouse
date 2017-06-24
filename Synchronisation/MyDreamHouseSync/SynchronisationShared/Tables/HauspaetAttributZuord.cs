using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class HauspaketAttributZuord : Table
    {
        public Nullable<int> HauspaketId { get; set; }
        public Nullable<int> WertId { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (hauspaket_id,wert_id) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, true);

            return query;
        }

        public override string GetPrimaryKeyColumn()
        {
            throw new NotImplementedException();
        }

        public override string GetTableName()
        {
            return "hauspaket_attribut_zuord";
        }
    }
}
