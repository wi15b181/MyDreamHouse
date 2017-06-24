using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class HauspaketAttribut : Table
    {
        public Nullable<int> AttributId { get; set; }
        public string AttributTyp { get; set; }
        public string AttributTypAnzeige { get; set; }

        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (attribut_id,attribut_typ,attribut_typ_anzeige) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, true);

            return query;
        }

        public override string GetPrimaryKeyColumn()
        {
            return "attribut_id";
        }

        public override string GetTableName()
        {
            return "hauspaket_attribut";
        }
    }
}
